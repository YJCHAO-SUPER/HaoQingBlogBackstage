<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\Model;

class Permission extends EntrustPermission
{
    //    查出所有的权限
    public function getPermissions(){
        return Permission::all();
    }
}
