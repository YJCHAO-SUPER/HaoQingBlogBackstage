<?php

namespace App\Http\Controllers;

use App\Role;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
//    显示角色管理
    public function roles(Request $request){
        $role = new Role();
        $data = $role->getRoles();

        return view('roles',['data'=>$data]);
    }

    //    显示添加管理员管理页面
    public function createManage(Request $request){
        $role = new Role();
        $data = $role->getRoles();

        return view('createManage',['data'=>$data]);
    }

//    处理添加管理页面
    public function insertManage(Request $request){
        $name = $request->name;
        $password = $request->password;
        $email = $request->email;
        $phone = $request->phone;

        $user = new User();
        $data = $user->addManage($name,$password,$email,$phone);
//        dd($data);

        $role_id = $request->role_id;
        $roleUser = new RoleUser();
        $roleUser->addManage($data,$role_id);

        return redirect('administrators');

    }

//    显示更新管理员管理页面
    public function showUpdateManage(Request $request){
        $id = $request->id;
        $user = new User();
        $data = $user->getManageById($id);

        $roleUser = new RoleUser();
        $result = $roleUser->getUpdateManage($id);

        return view('updateManage',['data'=>$data,'all'=>$result['all'],'checked'=>$result['checked']]);

    }

//    处理更新管理员管理页面
    public function updateManage(Request $request){
        $id = $request->id;
        $name = $request->name;
        $password = $request->password;
        $email = $request->email;
        $phone = $request->phone;

        $user = new User();
        $data = $user->updateOneManage($id,$name,$password,$email,$phone);

        $roleId = $request->role_id;
        $roleUser = new RoleUser();
        $roleUser->updateRoleUser($data,$roleId);

        return redirect('administrators');
    }

//    删除管理员
    public function deleteManage(Request $request){
        $id = $request->id;

        $user = new User();
        $user->deleteOne($id);

        return redirect('administrators');
    }



}
