<?php

namespace App\Http\Controllers;

use App\Permission;
use App\PermissionRole;
use App\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
//    显示权限管理
    public function permissions(Request $request){
        $permission = new Permission();
        $data = $permission->getPermissions();

        return view('permissions',['data'=>$data]);
    }

//    显示添加角色管理页面
    public function createRole(Request $request){
        $permission = new Permission();
        $data = $permission->getPermissions();

        return view('createRole',['data'=>$data]);
    }

//    处理添加角色管理
    public function insertRole(Request $request){
        $name = $request->name;
        $roleName = $request->roleName;
        $description = $request->description;

        $role = new Role();
        $data = $role->addRole($name,$roleName,$description);

        $per_id = $request->per_id;
        $perRole = new PermissionRole();
        $perRole->addPerRole($data,$per_id);

        return redirect('roles');

    }

//    显示修改角色管理页面
    public function showUpdateRole(Request $request){
        $roleId = $request->id;
        $role = new Role();
        $data = $role->showUpdate($roleId);

        $perRole = new PermissionRole();
        $perData = $perRole->showUpdate($roleId);
//        dd($perData);

        return view('updateRole',['data'=>$data,'checked'=>$perData['checked'],'all'=>$perData['all']]);
    }

//    处理修改角色管理
    public function updateRole(Request $request){
        $id = $request->id;
        $name = $request->name;
        $roleName = $request->roleName;
        $description = $request->description;

        $role = new Role();
        $data = $role->updateRoles($id,$name,$roleName,$description);

        $per_id = $request->per_id;
        $perRole = new PermissionRole();
        $perRole->updatePerRole($data,$per_id);

        return redirect('roles');
    }

//    删除角色
    public function deleteRole(Request $request){
        $roleId = $request->id;

        $role = new Role();
        $role->deleteOne($roleId);

        return redirect('roles');

    }


}
