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
}
