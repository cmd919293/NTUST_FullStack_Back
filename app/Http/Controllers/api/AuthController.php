<?php

namespace App\Http\Controllers\api;

use App\PasswordResets;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), User::REGISTER);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        User::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return response()->json([
            'status' => true,
            'message' => []
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), User::LOGIN);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => [
                    'error' => 'Unauthorized'
                ]
            ], 401);
        }
        return response()->json([
            'status' => true,
            'message' => $this->respondWithToken($token)
        ], 200);
    }

    /**
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'status' => true,
            'message' => $this->respondWithToken(auth('api')->refresh())
        ], 200);
    }

    /**
     * @param $token
     * @return array
     */
    protected function respondWithToken($token)
    {
        return [
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgetPwd(Request $request)
    {
        $validator = Validator::make($request->all(), User::FORGET);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $user = User::query()->where([
            'name' => $request['name'],
            'email' => $request['email']
        ])->get();
        if ($user->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => [
                    'User' => 'Not Found'
                ]
            ], 404);
        }
        $url = $request->header('origin', 'http://127.0.0.1');
        $token = md5(time());
        PasswordResets::query()->create([
            'token' => $token,
            'email' => $request['email']
        ]);
        $url .= "/auth/resetPwd/$token";
        //sent mail
        return response()->json([
            'status' => true,
            'message' => [
                'URL' => $url
            ]
        ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPwd(Request $request)
    {
        $validator = Validator::make($request->all(), User::RESET);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $record = PasswordResets::query()->where([
            'email' => $request['email'],
            'token' => $request['token']
        ])->where(DB::raw('TimeStampDiff(SECOND,`created_at`,now())'), '<', 600);
        if ($record->get()->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => [
                    'token' => 'Not Found or Expired'
                ]
            ], 404);
        }
        $record->delete();
        User::query()->where([
            'email' => $request['email']
        ])->update([
            'password' => Hash::make($request['password'])
        ]);
        return response()->json([
            'status' => true,
            'message' => [
                'password' => 'Reset Success'
            ]
        ]);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $user = auth('api')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => [
                    'Auth' => 'Not Login'
                ]
            ], 403);
        }
        User::query()
            ->where('id', $user->getAuthIdentifier())
            ->update([
                'name' => $request['name'],
                'password' => Hash::make($request['password'])
            ]);
        return response()->json([
            'status' => true,
            'message' => [
                'Config' => 'Success'
            ]
        ], 200);
    }
}
