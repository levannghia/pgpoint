<?php

namespace App\Modules\API\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Hash;

class Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->header('token')){
            return response()->json([
                'status'=>false,
                'code'=>400,
                'msg'=>'token is required'
            ]);
        }
        $token = $request->header('token');

        $api_token = DB::table('users')->select('api_token','id')->get();
        foreach ($api_token as $item){
            if(Hash::check($token,$item->api_token)){
                return $next($request);
            }
        }

        return response()->json([
            'status'=>false,
            'code'=>401,
            'msg'=>'unauthorized'
        ]);
    }
}
