<!doctype html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>简单通用的学生毕业设计后台模板</title>
    <link rel="stylesheet" type="text/css" href="css/common.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="/index" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="/index">首页</a></li>
                <li><a href="http://www.sucaihuo.com/" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="#">管理员</a></li>
                <li><a href="#">修改密码</a></li>
                <li><a href="#">退出</a></li>
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
                    <a href="#"><i class="icon-font">&#xe003;</i>常用操作</a>
                    <ul class="sub-menu">
                        <li><a href="/design"><i class="icon-font">&#xe008;</i>作品管理</a></li>
                        
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>系统管理</a>
                    <ul class="sub-menu">
                        <li><a href="/system"><i class="icon-font">&#xe017;</i>系统设置</a></li>
                        <li><a href="/system"><i class="icon-font">&#xe037;</i>清理缓存</a></li>
                        <li><a href="/system"><i class="icon-font">&#xe046;</i>数据备份</a></li>
                        <li><a href="/system"><i class="icon-font">&#xe045;</i>数据还原</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--/sidebar-->
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font">&#xe06b;</i><span>欢迎使用『豪情』博客程序，建博的首选工具。</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>快捷操作</h1>
            </div>
            <div class="result-content">
                <div class="short-wrap">
                    <a href="/insert"><i class="icon-font">&#xe001;</i>新增作品</a>
                    <a href="/insert"><i class="icon-font">&#xe005;</i>新增博文</a>
                    <a href="/insert"><i class="icon-font">&#xe048;</i>新增作品分类</a>
                    <a href="/insert"><i class="icon-font">&#xe041;</i>新增博客分类</a>
                    <a href="#"><i class="icon-font">&#xe01e;</i>作品评论</a>

                </div>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>作品列表</h1>
            </div>

            <form action="/index" method="get">
                查询：<input type="text" name="keyword">
                <input type="submit" value="搜索">
            </form>

            <table width="97%" border="1">

                <th>分类</th>
                <th>标题</th>
                <th>作者</th>
                <th>内容</th>
                <th>创作时间</th>
                <th>修改时间</th>
                <th>操作</th>
                @foreach($data as $v)
                <tr>
                    <td>{{  $v->getCategory['name'] }}</td>
                    <td>{{  $v->title }}</td>
                    <td>{{  $v->name }}</td>
                    <td>{{  $v->content }}</td>
                    <td>{{  $v->created_at }}</td>
                    <td>{{  $v->updated_at }}</td>
                    <td>
                        <a href="/showUpdate?id={{ $v->id  }}">修改</a>
                        <a href="/delete?id={{ $v->id  }}">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>
            {{ $data->links() }}
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>使用帮助</h1>
            </div>
            <div class="result-content">
                <ul class="sys-info-list">
                    <li>
                        <label class="res-lab">来源：</label><span class="res-info"><a href="http://www.sucaihuo.com/" target="_blank">素材火网</a></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/main-->
</div>
</body>
</html>