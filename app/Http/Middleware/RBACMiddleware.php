<?php

namespace App\Http\Middleware;

use App\Permission;
use App\PermissionRole;
use App\Role;
use App\RoleUser;
use App\User;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class RBACMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        获取路由
        $route = substr($request->getRequestUri(),1);
        $index = strpos($route,'?');
        $route = $index!=0?substr($route,0,$index):$route;
//        判断有没有登录
        if(Session::get('id')!=null){
//            获取当前用户的信息
            $user = User::where('id',session('id'))->first();
//            获取这个用户的角色信息
            $roleUser = RoleUser::where('user_id',$user->id)->get(['role_id'])->toArray();
            $roleArr = [];
            for ($i=0;$i<count($roleUser);$i++) {
                $roleArr[] = $roleUser[$i]['role_id'];
            }
            $permissions =PermissionRole::whereIn('role_id',$roleArr)->get()->toArray();
            $permissionArr = [];
            for ($i=0;$i<count($permissions);$i++){
                $permissionArr[] = $permissions[$i]['permission_id'];
            }
            $permissionInfo = Permission::whereIn('id',$permissionArr)->get(['name'])->toArray();
            $permissionInfoArr =  [];
            for ($i=0;$i<count($permissionInfo);$i++){
                $permissionInfoArr[] = $permissionInfo[$i]['name'];
            }
            if(in_array($route,$permissionInfoArr)){
                return $next($request);
            }else {
                return response('你还没有权限');
            }


//            dd($permission);


        }else{

            $allowRoutes= ['login','register','captcha2','getRegister','getLogin','sendMsg','alisms'];
            if(in_array($route,$allowRoutes)){
//                dd(123);
                return $next($request);
            }

            return redirect('/login');
        }

    }
}
