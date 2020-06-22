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
Route::get('/test/hello','TestController@hello');
Route::get('/test/redis1','TestController@redis1');
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


