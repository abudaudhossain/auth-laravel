<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;

class VisitorController extends Controller
{
    //
    public function addNewVisitor(Request $request){

        $input = $request->all();

        $visitor = new Visitor();
        $visitor ->phone = $input['phone'];
        $visitor->save();
        // if(Auth::attempt(['phone'=>$input['phone']])){
            // $visitor = Visitor::where('phone', $input['phone'])->first();
            $access_token = $visitor->createToken($input['phone'])->accessToken;
            Visitor::where('phone', $input['phone'])->update(['access_token' => $access_token]);
            $message = 'visitor SuccessFully Registered';

            return response() ->json(['message'=>$message,'access_token' => $access_token], 201);
            // return "pk";
        // }else{
        //     $message = 'Opps. Server Some thing wrong';

        //     return response()->json(['message'=> $message], 422);
        // } 

        return $visitor;
    }
}
