<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\UserModel;
class UserController extends Controller
{
    /**
     * 用户注册
    * @param Request $request
     * */
    public function reg(Request $request){

        $password =$request->input('password');

        $pwds =$request->input('pwds');
        $user_name =$request->input('user_name');
        $email =$request->input('email');

        //密码长度是否大于6
        $len = strlen($password);
        if($len<6){
            $response = [
                'error' => 50001,
                'msg' => '密码长度必须大于6'
            ];
            return $response;
        }

        //两次密码不一致
        if($password !=$pwds){
            $response = [
                'error' => 50002,
                'msg' => $pwds .'两次输入密码不一致'
            ];
            return $response;
        }

        //检查用户名是否存在
        $u = UserModel::where(['user_name'=>$user_name])->first();
        if($u){
            $response = [
                'error' => 50003,
                'msg' => $user_name .'用户名已存在'
            ];
            return $response;
        }
        //检查email是否存在
        $u = UserModel::where(['email'=>$email])->first();
        if($u) {
            $response = [
                'error' => 50004,
                'msg' => $email .'邮箱已存在'
            ];
            return $response;
        }

        $password = password_hash($pwds,PASSWORD_BCRYPT);


        //验证通过生成用户记录
        $data = [
            'user_name' =>$user_name,
            'email' =>$email,
            'password' =>$password,
            'reg_time' =>time(),
        ];

        $res = UserModel::insert($data);
        if($res){
            $response = [
                'error' =>0,
                'msg' =>"注册成功"
            ];
        }else{
            $response = [
                'error' =>50005,
                'msg' =>"注册失败"
            ];
        }
        return $response;
    }

}

