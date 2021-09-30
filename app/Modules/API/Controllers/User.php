<?php

namespace App\Modules\API\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class User extends Controller
{
    public function __construct()
    {
        $className = explode("\\", get_class())[4];
        //echo $className;
    }

    public function register(Request $request){
        $rules = [
            'email'=>'bail|required|email',
            'secret_key'=>'bail|required|',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'code'=>500,
                'msg'=>$validator->messages(),

            ]);
        }
        $email = $request->email;
        $secret_key = $request->secret_key;
        $check_user = DB::table('users')->where('email',$email)->where('app_id',$secret_key);
        if($check_user->exists()){
            return response()->json([
                'status'=>true,
                'code'=>200,
                'msg'=>'User already exist',
                'token'=>$check_user->first()->api_token
            ]);
        }
        $token = Str::random(80);
        $user_id = DB::table('users')->insertGetId([
            'email'=>$email,
            'app_id'=>$secret_key,
            'api_token'=>Hash::make($token),
            'created_at'=>Carbon::now()
        ]);
//        $token = DB::table('users')->where('id',$user_id)->get('api_token')->first();
        return response()->json([
            'status'=>true,
            'code'=>200,
            'msg'=>'Created User Successful',
            'token'=>$token
        ]);
    }
}
