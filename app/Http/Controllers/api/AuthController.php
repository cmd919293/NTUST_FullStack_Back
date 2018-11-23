<?php

namespace App\Http\Controllers\api;

use App\PasswordResets;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ]);
        }
        User::create([
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
        $credentials = request(['email', 'password']);
        if ($request->has('password') && $request->has('email')) {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token);
        } else {
            return response()->json(['error' => 'Bad Request'], 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgetPwd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|exists:users',
            'email' => 'required|string|email|max:255|exists:users'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ]);
        }
        $timeStr = time();
        $md5Str = md5($timeStr);
        $user = User::query()->where('name', $request['name'])->where('email', $request['email'])->get();
        User::where('name', $request['name'])
            ->where('email', $request['email'])
            ->update(['remember_token' => $timeStr]);
        PasswordResets::create([
            'email' => $request['email'],
            'token' => $md5Str
        ]);
        return response()->json([
            'status' => true,
            'token' => $md5Str
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function resetPwd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string|exists:password_resets',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ]);
        }
        $email = PasswordResets::where('token', $request['token'])->select('email')->get()[0]['email'];
        $timeStr = User::where('email', $email)->select('remember_token')->get()[0]->getAttributes();
        return $timeStr;
    }

    public function test($token)
    {
        $validator = Validator::make(['email' => $token], [
            'email' => 'required|string|email|max:255|exists:users'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ]);
        }
    }
}
