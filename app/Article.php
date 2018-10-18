<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
//    获取分类
    function getCategory(){
        return $this->belongsTo('App\\Category','category_id','id');
    }

    function categoryParent(){
        return $this->belongsTo('App\\Category','category_id','parent_id');
    }

//    获取所有文章
    public function getAllArticle($keyword=null,$category=null){
        if($category!=null && $keyword!=null){
            return $data = Article::with('getCategory')->with('categoryParent')->where('category_id',$category)->where('title','like',"%{$keyword}%")->paginate(10);
        }else if($keyword!=null){
            return $data = Article::with('getCategory')->with('categoryParent')->where('title','like',"%{$keyword}%")->paginate(10);
        }else if ($category!=null){
            return $data = Article::with('getCategory')->with('categoryParent')->where('category_id',$category)->paginate(10);
        }else{
            return $data = Article::with('getCategory')->with('categoryParent')->paginate(10);
        }

    }

//   插入文章
    public function addArticle($category,$title,$name,$image,$content){
        $insertArticle = new Article();
        $insertArticle->title = $title;
        $insertArticle->name = $name;
        $insertArticle->image = $image;
        $insertArticle->content = $content;
        $insertArticle->category_id = $category;
        $insertArticle->save();

    }

//    显示修改文章
    public function showUpdateArticle($id){
        return $data = Article::where('id',$id)->first();
    }

//    修改文章
    public function updateArticle($id,$category,$title,$name,$image,$content){

        $updateArticle = Article::find($id);
        $updateArticle->title = $title;
        $updateArticle->name = $name;
        $updateArticle->image = $image;
        $updateArticle->content = $content;
        $updateArticle->category_id = $category;
        $updateArticle->save();

    }

//    删除文章
    public function deleteOne($id){
        Article::find($id)->delete();
    }


}
