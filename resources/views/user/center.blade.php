<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table class="table table-striped" border="1">
    <caption></caption>
    <thead>
    <tr>
        <th>id</th>
        <th>用户名</th>
        <th>用户邮箱</th>
        <th>注册时间</th>
        <td>操作</td>
    </tr>
    </thead>
    <tbody>

        <tr>
            <td>{{$user->user_id}}</td>
            <td>{{$user->user_name}}</td>
            <td>{{$user->email}}</td>
            <td>{{date("Y-m-d H:i:s",$user->trg_time)}}</td>
            <td><a href="{{url('/user/edit/'.$user->user_id)}}" class="btn btn-success">
                    编辑</a> | <a  href="{{url('/user/destroy/'.$user->user_id)}}" class="btn btn-danger">
                    删除</a></td>
        </tr>



    </tbody>
</table>

</body>
</html>

