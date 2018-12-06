<?php

namespace App\Http\Controllers\api;

use App\CustomerReply;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomerReplyController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $imageNum = count($request->image);

        $id =  CustomerReply::create(['userID'=> auth('api')->user()->id,'imageNum' => $imageNum , 'resolved' => false ])->id;
        $prefix = 'customer-reply/'.$id.'/';
        //save text
        Storage::put($prefix.'reply.txt',$request->text);


        for($i= 0  ; $i < $imageNum ; $i++){
            Storage::putFileAs($prefix,$request->image[$i], $i.".png");
        }

        return response()->json([
            'success' => true,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //reserved
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //reserved
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //reserved
    }
}
