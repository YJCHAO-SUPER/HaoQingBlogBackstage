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
        Session(['milkcaptcha'=>$phrase]);
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

                    if($my->password==$password){
                        session(['id' => $my->id,'email' => $my->email]);
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

}
