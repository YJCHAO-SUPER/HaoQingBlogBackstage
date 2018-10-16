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
            <div class="crumb-list"><i class="icon-font"></i><a href="/jscss/admin/design/">首页</a><span class="crumb-step">&gt;</span><a class="crumb-name" href="/jscss/admin/design/">作品管理</a><span class="crumb-step">&gt;</span><span>新增作品</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/insertArticle" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    @csrf
                    <table class="insert-tab" width="100%">
                        <tbody>
                        <tr>
                            <th width="120"><i class="require-red">*</i>分类：</th>
                            <td>
                                <select name="category" id="catid" class="required" @change="getSecond()"  v-model="parentid">
                                    <option name="category" value="">请选择</option>

                                        <option  v-bind:value="item.id" v-for="item in first" v-text="item.name"></option>

                                </select>
                                <select name="category" id="catid" class="required" v-model="secondid" @change="getThird()">
                                    <option name="category" value="">请选择</option>

                                    <option  v-bind:value="item.id" v-for="item in second" v-text="item.name" >
                                    </option>

                                </select>
                                <select name="category" id="catid" class="required" v-model="thirdid">
                                    <option name="category" value="">请选择</option>

                                    <option  v-bind:value="item.id" v-for="item in third" v-text="item.name">
                                    </option>

                                </select>
                            </td>
                        </tr>
                            <tr>
                                <th><i class="require-red">*</i>标题：</th>
                                <td>
                                    <input class="common-text required" id="title" name="title" size="50" value="" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th>作者：</th>
                                <td><input class="common-text" name="name" size="50" value="admin" type="text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>缩略图：</th>
                                <td><input name="image[]" id="image" type="file" multiple @change="uploads()">
                                    <img :src="img" alt="" v-for="img in imgs" style="width: 100px;height: 100px;">

                                </td>

                            </tr>
                            <tr>
                                <th>内容：</th>
                                <td><textarea name="article" class="common-textarea" id="content" cols="30" style="width: 98%;" rows="10"></textarea></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                    <input class="btn btn6" onClick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
</div>
<script>
    new Vue({
        el: "#app",
        methods: {

            uploads(){
                let img = document.querySelector("#image");
                let files = img.files
                for(let i =0 ; i<files.length;i++) {
                    url = window.URL.createObjectURL(files[i])
                    this.imgs[i] = url
                }
                //强制更新  生命周期  本应该更新但页面没有更新
                this.$forceUpdate()
            },

            getFirst() {
                let para = {
                    parentid: this.parentid
                }
                axios({
                    methods: 'get',
                    url: 'http://localhost:8888/api/category',
                    params: para
                }).then((res)=>{
                    // console.log(res)
                    for(let i=0;i<res.data.length;i++) {
                        this.first.push({
                            id: res.data[i].id,
                            name: res.data[i].name
                        })
                    }
                })
            },
            getSecond() {
                this.thirdid = null;
                this.secondid = this.parentid
                let para = {
                    parentid: this.secondid
                }
                axios({
                    methods: 'get',
                    url: 'http://localhost:8888/api/category',
                    params: para
                }).then((res)=>{
                    this.second = []
                    for(let i=0;i<res.data.length;i++) {
                        this.second.push({
                            id: res.data[i].id,
                            name: res.data[i].name
                        })
                    }
                })
            },
            getThird() {
                let para = {
                    parentid: this.secondid
                }
                axios({
                    methods: 'get',
                    url: 'http://localhost:8888/api/category',
                    params: para
                }).then((res)=>{
                    this.third = []
                    for(let i=0;i<res.data.length;i++) {
                        this.third.push({
                            id: res.data[i].id,
                            name: res.data[i].name
                        })
                    }
                })
            }
        },

        data: function(){
            return {
                imgs: [],
                parentid: null,
                secondid: null,
                thirdid: null,
                first:[],
                second: [],
                third: []
            }
        },
        mounted: function() {
            this.getFirst()
        }
    })

</script>
</body>

</html>
