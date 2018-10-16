<!DOCTYPE html>
<html>
	
<head>
		<meta charset="utf-8">
		<title>登录界面</title>
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
							登录
						</div>
						<form action="/getLogin" method="post">
							@csrf
							{{@$error}}
							<div class="form_text_ipt">
								<input name="email" type="text" placeholder="邮箱">
							</div>
							<div class="ececk_warning"><span>邮箱不能为空</span></div>
							<div class="form_text_ipt">
								<input name="password" type="password" placeholder="密码">
							</div>
							<div class="ececk_warning"><span>密码不能为空</span></div>

							<input type="text" name="captcha" class="form-control" style="width: 300px;">
							<a ><img src="{{ URL('/captcha2').'/'.rand(0,9999999) }}"  alt="验证码" title="刷新图片" width="100" height="40" border="0"></a>
							<div class="form_check_ipt">
								<div class="left check_left">
									<label><input name="" type="checkbox"> 下次自动登录</label>
								</div>
								<div class="right check_right">
									<a href="#">忘记密码</a>
								</div>
							</div>
							<div class="form_btn">
								<button type="submit" >登录</button>
							</div>
							<div class="form_reg_btn">
								<span>还没有帐号？</span><a href="/register">马上注册</a>
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
	</body>
</html>