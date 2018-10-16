<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function create($name,$password,$email,$phone){
        DB::table('users')->insert(['name'=>$name,'password'=>$password,'email'=>$email,'phone'=>$phone]);
    }

    public function getUser($email){
        return $data = DB::table('users')->where('email',$email)->first();
    }
}
