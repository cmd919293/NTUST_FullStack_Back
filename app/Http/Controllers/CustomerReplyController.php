<?php

namespace App\Http\Controllers;

use App\CustomerReply;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CustomerReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $replies = CustomerReply::with('User')->paginate(10);
        $data = [
            'replies' => $replies,
        ];
        return view('customer-reply.index',$data);
    }

    /**
     * Show the form of CustomerReply for the specified resource.
     *
     * @param  \App\CustomerReply  $customerReply
     * @return \Illuminate\Http\Response
     */
    public function reply(CustomerReply $customerReply)
    {
        $image =[];
        for($i = 0 ; $i < $customerReply->imageNum; $i++)
        {
            $path =storage_path().'/app/customer-reply/'.$customerReply->id.'/'.$i.'.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $image[$i]=$base64;
        }
        $text = Storage::get('customer-reply/'.$customerReply->id.'/reply.txt');

        $data=[
            'reply' => $customerReply,
            'images'=> $image,
            'text' => $text,
        ];

        return view('customer-reply.reply',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerReply  $customerReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerReply $customerReply)
    {
        Storage::put('customer-reply/'.$customerReply->id.'/m_reply.txt',$request->reply);
        $customerReply->update(['resolved'=> true,]);
        $data=[
            'customerReply' => $customerReply,
        ];
        Mail::send('email.send', $data, function($message) use ($customerReply){
           $message->to($customerReply->User->email)->subject('POKESHOP REPLIED');
        });
        return redirect()->route('customer-reply.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //reserved
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //reserved
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerReply  $customerReply
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerReply $customerReply)
    {
        //reserved
    }


    /**
     * Display the specified reply.
     *
     * @param  \App\CustomerReply  $customerReply
     * @return \Illuminate\Http\Response
     *
     */
    public function read(CustomerReply $customerReply){
        if(auth()->user()->id != $customerReply->userID){
            return view('email.wrong-user');
        }
        else if(!($customerReply->resolved)){
            return view('email.error');
        }

        $images =[];
        for($i = 0 ; $i < $customerReply->imageNum; $i++)
        {
            $path =storage_path().'/app/customer-reply/'.$customerReply->id.'/'.$i.'.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $images[$i]=$base64;
        }
        $userText = Storage::get('customer-reply/'.$customerReply->id.'/reply.txt');
        $replyText = Storage::get('customer-reply/'.$customerReply->id.'/m_reply.txt');


        $data=[
            'reply' => $replyText,
            'text' => $userText,
            'images' => $images,
            'customerReply' => $customerReply,
        ];
        return view('email.customer-reply',$data);
    }

    private function mail(){

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerReply  $customerReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerReply $customerReply)
    {
        //reserved
    }
}
