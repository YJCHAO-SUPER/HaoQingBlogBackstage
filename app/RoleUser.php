<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    public $timestamps = false;

//    添加中间表数据
    public function addManage($data,$role_id){
        foreach ($role_id as $v){
            $roleUser = new RoleUser();
            $roleUser->role_id = $v;
            $roleUser->user_id = $data;
            $roleUser->save();
        }
    }

//    显示更新表数据
    public function getUpdateManage($id){
        $data = RoleUser::where('user_id',$id)->get(['role_id']);
//        dd($data);
        $all = Role::all();
        $result = [];
        $result['all'] = $all;
        $checked = [];
        foreach ($data as $v){
            $checked[] = Role::where('id',$v->role_id)->first(['id'])->id;
        }
//        dd($checked);
        $result['checked'] = $checked;
        return $result;

    }

//    更新数据表
    public function updateRoleUser($data,$roleId){
        RoleUser::where('user_id',$data)->delete();
        foreach ($roleId as $v){
            $roleUser = new RoleUser();
            $roleUser->user_id = $data;
            $roleUser->role_id = $v;
            $roleUser->save();
        }
    }

}
