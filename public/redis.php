<?php

    $redis = new Redis();       //实例化Redis

    //链接redis
    $redis->connect('127.0.0.1',6379);
    $redis->auth('admin@123');


    $k1 = 'name2';

    echo $redis->get($k1);


?>