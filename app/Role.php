<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;

class Role extends EntrustRole
{
    //    查出所有的角色
    public function getRoles(){
        return Role::all();
    }

//    添加角色
    public function addRole($name,$roleName,$description){
        $role = new Role();
        $role->name = $name;
        $role->display_name = $roleName;
        $role->description = $description;
        $role->save();
        return $role->id;
    }

//    根据id查出对应的角色信息
    public function showUpdate($roleId){
        return Role::where('id',$roleId)->first();
    }

//    更新角色
    public function updateRoles($id,$name,$roleName,$description){
        $role = Role::find($id);
        $role->name = $name;
        $role->display_name = $roleName;
        $role->description = $description;
        $role->save();
        return $role->id;
    }

//    删除角色
    public function deleteOne($roleId){
        return Role::where('id',$roleId)->delete();
    }


}
