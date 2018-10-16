<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
//   获取所有分类
    public function getAllCategory(){
        return Category::all(['id','name','level','parent_id']);
    }

}
