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

Route::any('/user/reg','User\UserController@reg');
//商品
Route::get('/goods/detail','Goods\GoodsController@detail');//商品详情
