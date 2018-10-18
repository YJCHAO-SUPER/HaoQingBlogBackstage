<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Captcha\Facades\Captcha;
use Gregwar\Captcha\CaptchaBuilder;
use Mrgoon\AliSms\AliSms;

class UserController extends Controller
{
//    显示登录页面
    public function login(Request $request){
        $ip = $request->getClientIp();
        $os = $this->GetOs();
        $browser = $this->GetBrowser();
        $equipment = $this->GetEquipment();
//        var_dump($equipment);
        return view('login');
    }

//    显示注册页面
    public function register(Request $request){
        return view('register');
    }

//    接收注册表单
    public function getRegister(Request $request){
//        接收表单
        if($request->code == session('token')) {

            if($request->phoneCode == session('code')){

                $validator = Validator::make($request->all(),[
                    'email' => 'required|email',
                    'phone'=> ['required','regex:/^1[34578][0-9]{9}$/'],
                ],[
                    'email.required'=>'邮箱必须填',
                    'email.email'=>'邮箱格式不正确',
                    'phone.regex'=>'手机号格式不正确',
                    'phone.required'=>'手机号码必须填'
                ]);
                if($validator->fails()){
//                    dd($validator->errors());
                    return redirect('/register')
                                        ->withErrors($validator->errors());
                }

                $password = $request->password;
                $email = $request->email;
                $name = $request->name;
                $phone = $request->phone;
                $user = new User();
                $user->create($name,$password,$email,$phone);
                return redirect('/login');

            }else {
                return redirect('/register')->withErrors(['phonecode'=>'手机验证码错误']);
            }
        }else {
            return redirect('/register')->withErrors(['code'=>'邮箱验证码错误']);
        }
    }

//    手机短信验证码
    public function alisms(Request $request) {
        $phone = $request->phone;
        $aliSms = new AliSms();
        $code = rand(0,9999);
        session(['code'=>$code]);
        $response = $aliSms->sendSms($phone, 'SMS_147970291', ['code'=> $code]);
        var_dump($response);
        $result = array(
            'code'=>200,
            'statu'=>true,
            'msg'=>'验证码发送成功'
        );
        return $result;
//dump($response);
    }

// 表单验证
    public function captcha()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
//dd($phrase);
//die();
        //把内容存入session
        session(['milkcaptcha'=>$phrase]);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

//    接收登录表单
    public function getLogin(Request $request){

        $email = $request->email;
        $password = $request->password;

        if ($email!='' && $password!=''){

            $count = session('error')?session('error'):1;
            if($count>=3) {
                $error = "登录失败超过3次";
                echo "登录失败超过三次,不能在登录";
                return view('/login',['error'=>$error]);
            }

            $users = new User();
            $my = $users->getUser($email);

            if ($my){

                if($request->captcha == session('milkcaptcha')) {
//                    dd(123);

                    if($my->password==$password){
//                        dd(22);
                        session(['id' => $my->id,'email' => $my->email]);
                        Session::put(['id'],[$my->id]);
//                        记录用户的IP，登录设备，浏览器
                        $ip = $request->getClientIp();
//                        dd($ip);


                        return redirect("/index");

                    }else{
                        $count++;
                        session(['error'=>$count]);
                        $error = "账号或者密码输入错误";
                        return view("/login",['error'=>$error]);
                    }
                }else {
                    $error = "验证码错误";
                    return view('/login',['error'=>$error]);
                }
            }else {
                $error = "没有该账号";
                return view("/login",['error'=>$error]);
            }
        }else{
            $error = "失败";
            return view("/login",['error'=>$error]);
        }

    }

//    发送激活邮件
    public function sendMsg(Request $request) {
        //接收ajax发来的email
        $email = $request->email;
        //产生随机数
        $token = rand(0,9999);
        //存到session
        session(['token'=>$token]);
        //定义view里的数组
        $send = [
            'username' => $request->email,
            'token' => $token
        ];
        //发送邮件，
        Mail::send('mail',['send'=>$send],function($send) use ($email) {
            $to = $email;
            $send->to($to)->subject('欢迎注册');
        });

        echo 1;
    }

    //获取客户端操作系统信息包括win10
    function GetOs(){
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $os = false;

        if (preg_match('/win/i', $agent) && strpos($agent, '95'))
        {
            $os = 'Windows 95';
        }
        else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))
        {
            $os = 'Windows ME';
        }
        else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))
        {
            $os = 'Windows 98';
        }
        else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))
        {
            $os = 'Windows Vista';
        }
        else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))
        {
            $os = 'Windows 7';
        }
        else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))
        {
            $os = 'Windows 8';
        }else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))
        {
            $os = 'Windows 10';#添加win10判断
        }else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))
        {
            $os = 'Windows XP';
        }
        else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))
        {
            $os = 'Windows 2000';
        }
        else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))
        {
            $os = 'Windows NT';
        }
        else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))
        {
            $os = 'Windows 32';
        }
        else if (preg_match('/linux/i', $agent))
        {
            $os = 'Linux';
        }
        else if (preg_match('/unix/i', $agent))
        {
            $os = 'Unix';
        }
        else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent))
        {
            $os = 'SunOS';
        }
        else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent))
        {
            $os = 'IBM OS/2';
        }
        else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent))
        {
            $os = 'Macintosh';
        }
        else if (preg_match('/PowerPC/i', $agent))
        {
            $os = 'PowerPC';
        }
        else if (preg_match('/AIX/i', $agent))
        {
            $os = 'AIX';
        }
        else if (preg_match('/HPUX/i', $agent))
        {
            $os = 'HPUX';
        }
        else if (preg_match('/NetBSD/i', $agent))
        {
            $os = 'NetBSD';
        }
        else if (preg_match('/BSD/i', $agent))
        {
            $os = 'BSD';
        }
        else if (preg_match('/OSF1/i', $agent))
        {
            $os = 'OSF1';
        }
        else if (preg_match('/IRIX/i', $agent))
        {
            $os = 'IRIX';
        }
        else if (preg_match('/FreeBSD/i', $agent))
        {
            $os = 'FreeBSD';
        }
        else if (preg_match('/teleport/i', $agent))
        {
            $os = 'teleport';
        }
        else if (preg_match('/flashget/i', $agent))
        {
            $os = 'flashget';
        }
        else if (preg_match('/webzip/i', $agent))
        {
            $os = 'webzip';
        }
        else if (preg_match('/offline/i', $agent))
        {
            $os = 'offline';
        }
        else
        {
            $os = '未知操作系统';
        }
        return $os;
    }

    //获得访客浏览器类型
    function GetBrowser()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } elseif (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } elseif (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } elseif (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } elseif (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return false;
        }
    }

    //获取访客设备
    function GetEquipment(){
        //获取USER AGENT
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        //分析数据
        $is_pc = (strpos($agent, 'windows nt')) ? true : false;
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;

        //输出数据
        if($is_pc){
            return "PC";
        }
        if($is_iphone){
            return "iPhone";
        }
        if($is_ipad){
            return "iPad";
        }
        if($is_android){
            return "Android";
        }
    }

//    显示管理员管理
    public function administrators(){
        $users = new User();
        $data =$users->getAdmin();

        return view('administrators',['data'=>$data]);
    }




}
