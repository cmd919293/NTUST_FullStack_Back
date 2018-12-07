<?php

namespace App\Http\Controllers;

use App\UserComment;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = UserComment::with(['User','Product'])->paginate('10');
        $data=[
            'comments' => $comments
        ];
//        dd($data);
        return view('user-comment.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserComment  $userComment
     * @return \Illuminate\Http\Response
     */
    public function show(UserComment $userComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserComment  $userComment
     * @return \Illuminate\Http\Response
     */
    public function edit(UserComment $userComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserComment  $userComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserComment $userComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserComment  $userComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserComment $userComment)
    {
        UserComment::destroy($userComment->id);
        return redirect()->route('user-comment.index');
    }
}
