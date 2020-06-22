<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\UserModel;
class UserController extends Controller
{
    public function reg(){
        return view('user.reg');
    }
    //注册执行
    public function regDo(){
        $data=request()->except("_token");
        $validator=Validator::make($data,[
            'user_name'=>'required|unique:users',
            'email'=>'required|unique:users',
            'password'=>'required|min:6',
            'pwds'=>'required',
        ],[
            'user_name.required'=>'用户名不能为空',
            'user_name.unique'=>'用户名重复',
            'email.required'=>'邮箱不能为空',
            'email.unique'=>'邮箱已绑定，请您换个邮箱',
            'password.required'=>'密码不能为空',
            'password.min'=>'密码至少为六位',
            'pwds.required'=>'确认密码不能为空',
        ]);
        if($validator->fails()){
            return redirect('/user/reg')->withErrors($validator)->withInput();
        }
        if($data['pwds']!=$data['password']){
            return redirect('/user/reg')->with('a','确认密码和密码不一致');
        }
        array_pop($data);
        $data['reg_time']=time();
        $options =[
          'cost' =>12,
        ];
//    array_pop($data);
        $data['password']=password_hash($data['password'],PASSWORD_BCRYPT,$options);
        $res = UserModel::insert($data);
        if($res){
            return redirect('/user/login');
        }
        //dd($res);
    }
}
