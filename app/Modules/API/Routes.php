<?php
//API routes
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'API', 'middleware' => 'api', 'namespace' => "App\Modules\API\Controllers"], function () {

    Route::group(["prefix" => "api"], function () {
        Route::post("register", ["as" => "api.user.register", "uses" => "User@register"]);
        Route::group(["prefix"=>"point",'middleware' => 'token'],function (){
            Route::post("getPoint", ["as" => "api.point.balance_get", "uses" => "Point@getPoint"]);
            Route::post("addPoint", ["as" => "api.point.add", "uses" => "Point@addPoint"]);
        });
    });

});