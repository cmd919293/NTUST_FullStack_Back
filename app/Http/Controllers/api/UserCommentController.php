<?php

namespace App\Http\Controllers\api;

use App\UserComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ProductId' => 'required|numeric',
            'Comment' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $Uid = auth('api')->user()->getAuthIdentifier();
        UserComment::query()
            ->create([
                'UserId' => $Uid,
                'ProductId' => $request['ProductId'],
                'Comment' => $request['Comment']
            ]);
        return response()->json([
            'status' => true,
            'message' => []
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ProductId' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()
            ], 400);
        }
        $comments = UserComment::query()
            ->where('ProductId', '=', $request['ProductId'])
            ->select('UserId', 'Comment', 'created_at as createdAt')
            ->orderBy('createdAt', 'desc')
            ->get();
        return response([
            'status' => true,
            'message' => [],
            'comment' => $comments
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\UserComment $userComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserComment $userComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserComment $userComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserComment $userComment)
    {
        //
    }
}
