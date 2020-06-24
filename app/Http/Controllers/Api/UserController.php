<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Model\UserModel;
use App\Model\TokenModel;
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

    //登录执行
    public function login(Request $request){

        $user_name =$request->input("user_name");
        $password =$request->input("password");
        //验证登录信息
        $u = UserModel::where(['user_name'=>$user_name])->first();

        //验证密码
        $res = password_verify($password,$u->password);

        if($res){
            $str = $u->user_id . $u->user_name . time();
            $token = substr(md5($str),10,16) . substr(md5($str),0,10);

            //保存token后续验证使用
            $data = [
                'uid' =>$u->user_id,
                'token' =>$token
            ];

            TokenModel::insert($data);

            $response = [
                'error' =>0,
                'msg'=>'ok',
                'token' =>$token
            ];
        }else{
            $response = [
                'error' =>50006,
                'msg'=>'用户名与密码不一致，请重新登录',
            ];

        }
        return $response;
    }


    //个人中心
    public function center(){
        //判断用户是否登录，判断是否有id字段

        $token =$_GET['token'];
        //检查token是否有效
        $res = TokenModel::where(['token'=>$token])->first();
        if($res){
            $uid = $res->uid;
            $userinfo =UserModel::find($uid);

            //已登陆
           echo $userinfo->user_name .  "欢迎来到个人中心";
        }else{
            //未登录
            echo "请登录";
        }

    }
}

