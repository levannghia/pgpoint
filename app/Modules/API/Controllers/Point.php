<?php

namespace App\Modules\API\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class Point extends Controller
{
    public function __construct()
    {
        $className = explode("\\", get_class())[4];
        //echo $className;
    }

    public function getPoint(Request $request){
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
        $secret_key = $request->secret_key;
        $email = $request->email;
        $point = DB::table('users')->where('users.email',$email)->where('users.app_id',$secret_key)
                ->join('point','point.user_id','users.id')
                ->select('point.value')->first();

        return response()->json([
            'status'=>true,
            'code'=>200,
            'msg'=>'Data returned successfully',
            'data'=>$point
        ]);
    }
    public function addPoint(Request $request){
        $rules = [
            'email'=>'bail|required|email',
            'secret_key'=>'bail|required|',
            'point'=>'bail|required|numeric|min:0|not_in:0',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'code'=>500,
                'msg'=>$validator->messages(),

            ]);
        }

        $secret_key = $request->secret_key;
        $email = $request->email;
        $point = $request->point;
        //lay point trong db
        $point_db = DB::table('users')->where('users.email',$email)->where('users.app_id',$secret_key)
            ->join('point','point.user_id','users.id')
            ->select('point.id','point.value','point.user_id')->first();

        //update point
        DB::table('point')->where('id',$point_db->id)->update([
            'value'=>$point_db->value + $point,
            'updated_at'=>Carbon::now()
        ]);
        //insert table transaction_history
        DB::table('transaction_history')->insert([
            'user_id'=> $point_db->user_id,
            'point'=>$point,
            'type'=>1,
            'created_at'=>Carbon::now()
        ]);
        return response()->json([
            'status'=>true,
            'code'=>200,
            'msg'=>'Transaction successfully',
        ]);
    }
}
