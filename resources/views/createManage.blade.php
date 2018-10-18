<!doctype html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="css/common.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17-beta.0/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
</head>
<body>
<div id="app">
    <div class="topbar-wrap white">
        <div class="topbar-inner clearfix">
            <div class="topbar-logo-wrap clearfix">
                <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
                <ul class="navbar-list clearfix">
                    <li><a class="on" href="/index">首页</a></li>
                    <li><a href="#" target="_blank">网站首页</a></li>
                </ul>
            </div>
            <div class="top-info-wrap">
                <ul class="top-info-list clearfix">
                    <li><a href="http://www.sucaihuo.com">管理员</a></li>
                    <li><a href="http://www.sucaihuo.com">修改密码</a></li>
                    <li><a href="http://www.sucaihuo.com">退出</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container clearfix">
        <div class="sidebar-wrap">
            <div class="sidebar-title">
                <h1>菜单</h1>
            </div>
            <div class="sidebar-content">
                <ul class="sidebar-list">
                    <li>
                        <a href="#"><i class="icon-font">&#xe003;</i>添加管理</a>
                        <ul class="sub-menu">
                            <li><a href="/createRole"><i class="icon-font">&#xe046;</i>添加角色管理</a></li>
                            <li><a href="/createManage"><i class="icon-font">&#xe046;</i>添加管理员管理</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="icon-font">&#xe018;</i>管理员模块</a>
                        <ul class="sub-menu">
                            <li><a href="/permissions"><i class="icon-font">&#xe017;</i>权限管理</a></li>
                            <li><a href="/roles"><i class="icon-font">&#xe037;</i>角色管理</a></li>
                            <li><a href="/administrators"><i class="icon-font">&#xe046;</i>管理员管理</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--/sidebar-->

        <h1 style="color: darkblue; font-size: 20px">添加管理员管理</h1><br>
        <form action="/insertManage" method="post" enctype="multipart/form-data">
            @csrf
            添加管理员：<br>
                        用户名：<input type="text" name="name"><br>
                        密码：<input type="password" name="password"><br>
                        邮箱：<input type="text" name="email"><br>
                        电话号码：<input type="text" name="phone"><br>

            选择角色：<ul>
                @foreach($data as $v)
                    <li><input type="checkbox" name="role_id[]" value="{{ $v->id }}">{{ $v->display_name }}</li>
                @endforeach
            </ul>
            <br>
            <input type="submit" value="添加">
        </form>

        <!--/main-->
    </div>
</div>

</body>

</html>
