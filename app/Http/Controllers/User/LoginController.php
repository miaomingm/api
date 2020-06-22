<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\UserModel;
class LoginController extends Controller
{
   public function login(){
       return view('user.login');
   }
    //登录执行
    public function loginDo(){
        $data=request()->except('_token');
        $validator=Validator::make($data,[
            'user_name'=>'required',
            'password'=>'required',
        ],[
            'user_name.required'=>'用户名不能为空',
            'password.required'=>'密码不能为空',
        ]);
        if($validator->fails()){
            return redirect('user/login')->withErrors($validator)->withInput();
        }
        $where=[
            ["user_name","=",$data['user_name']],
            ["password","=",$data['password']]
        ];
        $res=UserModel::where($where)->get();
        if($res){
            return redirect('/user/center');
        }else{
            return redirect('user/login')->with("cuowu","密码错误，请重新登陆");
        }
    }
    public function center(){
        return view('user.center');
    }
}
