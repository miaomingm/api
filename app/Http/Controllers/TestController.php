<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    public function hello(){
        echo __METHOD__;echo '</br>';
        echo date('Y-m-d H:i:s');
    }

    //redis测试
    public function redis1(){
        $key = 'name1';
        $val1 = Redis::get($key);
        var_dump($val1);echo '</br>';
        echo '$val1: '.$val1;
    }

    public function test1(){
        $data = [
            'name' =>'zhangsan',
            'email' => 'zhangsan@qq.com'
        ];
        return $data;
    }

    //签名测试
    public function sign1(){
        $key = '1910';
        $data = 'hello word';
        $sign = md5($data.$key);

        echo "要发送的数据:" .$data;echo '</br>';
        echo "发送前生成的签名:" .$sign;echo '<hr>';

        $b_url = 'http://1910x.com/test/secret?data='.$data.'&sign='.$sign;

        echo $b_url;
    }

    public function secret(){
        echo '<pre>';print_r($_GET);echo '</pre>';
        $key = '1910';
        //收到数据 验证签名
        $data = $_GET['data'];  //接受到的数据
        $sign = $_GET['sign'];  //接受到的签名

        $local_sign = md5($data.$key);
        echo '本地计算的签名:' .$local_sign;echo '</br>';

        if($sign == $local_sign){
            echo "验签通过";
        }else{
            echo "验牵失败";
        }
    }

    public function www(){
        $key = '1910';
        $url = 'http://api.1910x.com/api/info';
        //向接口发送数据
        //get方式发送
        $data = 'hello';
        $sign = sha1($data.$key);
        $url = $url . '?data='.$data.'&sign=' .$sign;
        //发起网络请求
        $response = file_get_contents($url);
        echo $response;
    }

    /**
     * 请求接口
    */
    public function sendData(){
        $url = 'http://api.1910x.com/test/receive';
        $response = file_get_contents($url);

        echo $response;
    }

    /**
    *向接口post数据
     */
    public function postData(){

        $key = 'secret';
        $data = [
            'user_name' => 'wangkangjie',
            'user_age'  => 19
        ];

        $str = json_encode($data).$key;
        $sign = sha1($str);

        $send_data = [
            'data'  => json_encode($data),
            'sign'  => $sign
        ];

        $url = 'http://api.1910x.com/test/receive-post';
        //使用 curl post数据
        // 1 实例化
        $ch = curl_init();

        // 2 配置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);        // 使用post 方式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$send_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);   // 通过变量接收响应

        // 3 开启会话（发送请求）
        $response = curl_exec($ch);

        // 4 检测错误
        $errno = curl_errno($ch);       //错误码
        $errmsg = curl_error($ch);

        if($errno)
        {
            echo '错误码： '.$errno;echo '</br>';
            var_dump($errmsg);
            die;
        }

        curl_close($ch);

        echo $response;

    }

    /**
     * 对称加密
    */
    public function encrypt1(){
        $data = '长江，我是黄河';
        $method ='AES-256-CBC';     //加密算法
        $key = '1910api';           //加密密钥
        $iv = 'hellohellohelloa';   //初始向量

        //加密数据
        $enc_data = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        //echo "加密后的密文:" .$enc_data;

        //签名
        $sign = sha1($enc_data.$key);

        //组合post数据
        $post_data =[
            'data' => $enc_data,
            'sign' =>$sign
        ];
        //将密文发送至对端 post
        $url = 'http://api.1910x.com/test/decrypt1';
        //初始化init
        $ch = curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);      //post 地址
        curl_setopt($ch,CURLOPT_POST,1);    //post方式发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);  //post的数据
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //开启会话 (发送请求)
        $response = curl_exec($ch);     //接收响应
        echo $response;
        //捕捉错误
        $errno = curl_errno($ch);
        if($errno){
            $errmsg = curl_error($ch);
            var_dump($errmsg);
            die;
        }

        //关闭链接
        curl_close($ch);

    }
}
