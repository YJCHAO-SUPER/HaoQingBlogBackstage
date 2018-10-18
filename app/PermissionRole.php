<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    public $timestamps = false;

//    添加中间表数据
    public function addPerRole($data,$per_id){

        foreach ($per_id as $v){
            $perRole = new PermissionRole();
            $perRole->permission_id = $v;
            $perRole->role_id = $data;
            $perRole->save();
        }

    }

//    显示修改中间表
    public function showUpdate($roleId){
        $data = PermissionRole::where('role_id',$roleId)->get(['permission_id']);
//        dd($data);
        $all = Permission::all();
        $result = [];
        $result['all'] = $all;
        $checked=[];
        foreach ($data as $v){
            $checked[] = Permission::where('id',$v->permission_id)->first(['id'])->id;
        }
//        dd($checked);
        $result['checked'] = $checked;
        return $result;
    }

//    修改中间表
    public function updatePerRole($data,$per_id){

            PermissionRole::where('role_id',$data)->delete();
            foreach ($per_id as $v) {
                $perRole = new PermissionRole();
                $perRole->permission_id = $v;
                $perRole->role_id = $data;
                $perRole->save();
            }
    }

}
