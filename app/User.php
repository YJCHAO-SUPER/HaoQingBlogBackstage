<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use EntrustUserTrait;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function create($name,$password,$email,$phone){
        DB::table('users')->insert(['name'=>$name,'password'=>$password,'email'=>$email,'phone'=>$phone]);
    }

    public function getUser($email){
        return $data = DB::table('users')->where('email',$email)->first();
    }

//    查出所有的管理者
    public function getAdmin(){
        return User::all();
    }

//    添加管理者
    public function addManage($name,$password,$email,$phone){
        $user = new User();
        $user->name = $name;
        $user->password = $password;
        $user->email = $email;
        $user->phone = $phone;
        $user->save();
        return $user->id;
    }

//    显示更新管理者管理的页面
    public function getManageById($id){
        return User::where('id',$id)->first();
    }

//    更新管理员管理的页面
    public function updateOneManage($id,$name,$password,$email,$phone){
        $user = User::find($id);
        $user->name = $name;
        $user->password = $password;
        $user->email = $email;
        $user->phone = $phone;
        $user->save();
        return $user->id;
    }

//    删除管理者
    public function deleteOne($id){
        return User::where('id',$id)->delete();
    }


}
