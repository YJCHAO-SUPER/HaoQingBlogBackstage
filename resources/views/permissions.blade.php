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


        <h2 style="color: darkblue; font-size: 20px">权限列表</h2>
        <table border="1" width="85%">

            <th>权限英文名称</th>
            <th>权限名称</th>
            <th>权限描述</th>
            <th>操作</th>
            @foreach($data as $v)
                <tr>
                    <td>{{ $v->name }}</td>
                    <td>{{ $v->display_name }}</td>
                    <td>{{ $v->description }}</td>
                    <td>
                        <a href="#">修改</a>
                        <a href="#">删除</a>
                    </td>
                </tr>
            @endforeach

        </table>


        <!--/main-->
    </div>
</div>

</body>

</html>
