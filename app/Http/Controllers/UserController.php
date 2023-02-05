<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use  Validator;
use Auth;

class UserController extends Controller
{
    //
    public function regUser(Request $request){
        
        $data = $request->all();
     
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ];

        $customMessage = [
            'name.required' =>"Name is required",
            'email.required' =>'Email is required',
            'email.email'=> 'Email must be a valid email',
            'password.required' => 'Password is required'
        ];

        $validator = Validator::make($data, $rules, $customMessage);
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = new User();
        $user ->name = $data['name'];
        $user ->email = $data['email'];
        $user ->type = $data['type'];
        $user ->password =Hash::make($data['password']);
        $user->save();
        if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
            $user = User::where('email', $data['email'])->first();
            $access_token = $user->createToken($data['email'])->accessToken;
            User::where('email', $data['email'])->update(['access_token' => $access_token]);
            $message = 'user SuccessFully Registered';

            return response() ->json(['message'=>$message,'access_token' => $access_token], 201);
        }else{
            $message = 'Opps. Server Some thing wrong';

            return response()->json(['message'=> $message], 422);
        }      

    }
}
