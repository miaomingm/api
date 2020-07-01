<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/info', function () {
    phpinfo();

});

//测试
Route::prefix("/test")->group(function(){
    Route::get('/hello','TestController@hello');
    Route::get('/redis1','TestController@redis1');
    Route::get('/test1','TestController@test1');
    Route::get('/sign1','TestController@sign1');
    Route::get('/secret','TestController@secret');
    Route::get('/www','TestController@www');
    Route::get('/sendData','TestController@sendData');
    Route::get('/postData','TestController@postData');
    Route::get('/encrypt1','TestController@encrypt1');
    Route::get('/rsa/sendb','TestController@sendB');
});

//商品
Route::get('/goods/detail','Goods\GoodsController@detail');//商品详情

//前台注册
Route::get('/user/reg','User\UserController@reg');//注册试图
Route::post('/user/regDo','User\UserController@regDo');//执行注册
//前台登录
Route::get('/user/login','User\LoginController@login');//登录试图
Route::post('/user/loginDo','User\LoginController@loginDo');//执行登录
//Route::get('user/center','User\LoginController@center');//用户中心

Route::prefix("/user")->middleware("isLogin")->group(function(){
    //个人中心
    Route::get('/center','User\LoginController@center');//用户中心
});

//APi
Route::post('/api/user/reg','Api\UserController@reg'); //aip注册
Route::post('/api/user/login','Api\UserController@login'); //aip登录
Route::get('/api/user/center','Api\UserController@center')->middleware('isLogin'); //aip个人中心
Route::get('/api/my/orders','Api\UserController@orders')->middleware('isLogin'); //我的订单
Route::get('/api/my/cart','Api\UserController@cart')->middleware('isLogin'); //我的购物车

Route::middleware("isLogin","access.filter")->group(function() {
    Route::get('/api/a', 'Api\TestController@a');
    Route::get('/api/b', 'Api\TestController@b');
    Route::get('/api/c', 'Api\TestController@c');
    Route::get('/api/x', 'Api\TestController@x');
    Route::get('/api/y', 'Api\TestController@y');
    Route::get('/api/z', 'Api\TestController@z');
});