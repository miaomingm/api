<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    public $table = 'tokens';  //声明model使用的表
    public $timestamps = false; //时间戳
}
