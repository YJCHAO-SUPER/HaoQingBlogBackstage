<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<title>注册界面</title>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/common1.css" />
		<link rel="stylesheet" href="css/font-awesome.min.css" />
	</head>
	<body>
		<div class="wrap login_wrap">
			<div class="content">
				
				<div class="logo"></div>
				
				<div class="login_box">	
					
					<div class="login_form">
						<div class="login_title">
							注册
						</div>
						<form action="/getRegister" method="post">
							@csrf
							<div class="form_text_ipt">
								<input name="email" type="text" placeholder="邮箱" id="email">
								<input id="sendEmail" type="button" onclick="sendEmail()" value="发送激活邮件">
							</div>
							<br>
							@if($errors->has('email'))
							<div class="ececk_warning" style="display: block;"><span>{{$errors->get('email')[0]}}</span></div>
							@endif
							<br>
							<div class="ececk_warning"><span>邮箱不能为空</span></div>

							<div class="form_text_ipt">
								<input type="text" name="code" placeholder="邮箱验证码">
							</div>
							@if($errors->has('code'))
								<div class="ececk_warning" style="display: block;"><span>{{$errors->get('code')[0]}}</span></div>
							@endif
							<div class="ececk_warning"><span>邮箱验证码不能为空</span></div>

							<div class="form_text_ipt">
								<input name="name" type="text" placeholder="名字">
							</div>
							<div class="ececk_warning"><span>名字不能为空</span></div>

							<div class="form_text_ipt">
								<input id="phone" name="phone" type="text" placeholder="电话号码">
								<input type="button"  value="发送短信验证码" id="sendSmsButton">
							</div>
							<br>
							@if($errors->has('phone'))
								<div class="ececk_warning" style="display: block;"><span>{{$errors->get('phone')[0]}}</span></div>
							@endif
							<br>
							<div class="ececk_warning"><span>电话号码不能为空</span></div>

							<div class="form_text_ipt">
								<input type="text" name="phoneCode" placeholder="短信验证码">
							</div>
							@if($errors->has('phonecode'))
								<div class="ececk_warning" style="display: block;"><span>{{$errors->get('phonecode')[0]}}</span></div>
							@endif
							<div class="ececk_warning"><span>短信验证码不能为空</span></div>

							<div class="form_text_ipt">
								<input name="password" type="password" placeholder="密码">
							</div>
							<div class="ececk_warning"><span>密码不能为空</span></div>
							<div class="form_text_ipt">
								<input name="repassword" type="password" placeholder="重复密码">
							</div>
							<div class="ececk_warning"><span>密码不能为空</span></div>
							
							<div class="form_btn">
								<button type="submit">注册</button>
							</div>
							<div class="form_reg_btn">
								<span>已有帐号？</span><a href="/login">马上登录</a>
							</div>
						</form>
						<div class="other_login">
							<div class="left other_left">
								<span>其它登录方式</span>
							</div>
							<div class="right other_right">
								<a href="#"><i class="fa fa-qq fa-2x"></i></a>
								<a href="#"><i class="fa fa-weixin fa-2x"></i></a>
								<a href="#"><i class="fa fa-weibo fa-2x"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.min.js" ></script>
		<script type="text/javascript" src="js/common.js" ></script>
		<script type="text/javascript" src="js/laravel-sms.js"></script>
	</body>
</html>
<script>

	
	$(function () {
            $("#sendEmail").click(function() {
                $.ajax({
                    url:"/sendMsg",
                    type:"get",
                    data: $("#email"),
                    dataType: 'json',
                    success:function ($data) {

                    }
                })
			});

			$("#sendSmsButton").click(function() {
			    $.ajax({
					url: '/alisms',
					method: 'get',
					data: $("#phone"),
					dataType: 'json',
					success: function(data) {
					    if(data.statu==true) {
					        alert(data.msg)
						}
					}
				})
			})
    })

</script>
