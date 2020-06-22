
<form action="{{url('user/regDo')}}" method="post">
    @csrf
    用户名<input type="text" name="user_name"><font color="red">{{$errors->first('user_name')}}</font><br>

    邮箱<input type="text" name="email"><font color="red">{{$errors->first('email')}}</font><br>
    密码<input type="password" name="password"><font color="red">{{$errors->first('password')}}</font><br>
    确认密码<input type="password" name="pwds"><font color="red">{{$errors->first('pwds')}}</font><br>
    <input type="submit" value="点击注册">
</form>