<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class IndexController extends Controller
{
//    展示列表
    public function index(Request $request){

        $keyword = $request->keyword;
        $getArticle = new Article();
        $filter = $request->only('category');

        if(isset($keyword) && isset($filter['category'])){
            $data = $getArticle->getAllArticle($keyword,$request->category);
        }else if (isset($keyword)){
            $data = $getArticle->getAllArticle($keyword);
        }else if (isset( $filter['category'])){
            $data = $getArticle->getAllArticle($request->category);
        }else{
            $data = $getArticle->getAllArticle();
        }

        return view('index',['data'=>$data]);
    }

//      显示数据
    public function insert(Request $request){

        $category = new Category();
        $data = $category->getAllCategory();

        return view('insert',['data'=>$data]);
    }

//    插入数据
    public function insertArticle(Request $request){

        $category = $request->category;
        $title = $request->title;
        $name = $request->name;
        $content = $request->article;
//        上传图片
        $file = $request->file('image');
//              图片目录
            $date = date("Y-m-d");
            Storage::disk('public')->makeDirectory($date);
            Storage::disk('public')->makeDirectory($date."\\big");
            Storage::disk('public')->makeDirectory($date."\\mid");
            Storage::disk('public')->makeDirectory($date."\\sml");

        $str = "";
            for ($i=0;$i<count($file);$i++) {
                $path = Storage::disk('public')->put($date, $file[$i]);
                if($i==count($file)-1) {
                    $str.=$path;
                }else {
                    $str.=$path."|";
                }
            }


//       生成缩略图
        $imgs=[];
        $image = explode('|',$str);
        for($i=0;$i<count($image);$i++){

            $imgs[$i] = Image::make(storage_path("app\\public\\$image[$i]"));
            $imgs[$i]->resize(300,300);
            $image[$i] = substr($image[$i],11);
            $imgs[$i]->save(storage_path("app\\public\\$date\\big\\$image[$i]"));
            $imgs[$i]->resize(150,150);
            $imgs[$i]->save(storage_path("app\\public\\$date\\mid\\$image[$i]"));
            $imgs[$i]->resize(50,50);
            $imgs[$i]->save(storage_path("app\\public\\$date\\sml\\$image[$i]"));

        }

        $article = new Article();
        $article->addArticle($category,$title,$name,$str,$content);

        return redirect('/index');
    }

//    显示修改数据页面
    public function showUpdate(Request $request){

        $id = $request->id;
        $upArticle = new Article();
        $data = $upArticle->showUpdateArticle($id);


        $imgPath = $data->image;
        $imgPath = explode('|',$imgPath);
        for($i=0;$i<count($imgPath);$i++){
            $fullPath[$i] = "/storage/".$imgPath[$i];
        }

//        dd($fullPath);

        $category = new Category();
        $category = $category->getAllCategory();

        return view('/update',['data'=>$data,'category'=>$category,'fullPath'=>$fullPath]);

    }

//    修改文章
    public function updateArticle(Request $request){

        $id = $request->id;
        $category = $request->category;
        $title = $request->title;
        $name = $request->name;
        $content = $request->article;
        $file = $request->file('image');
//              图片目录
        $date = date("Y-m-d");
        Storage::disk('public')->makeDirectory($date);
        $str = "";
        for ($i=0;$i<count($file);$i++) {
            $path = Storage::disk('public')->put($date, $file[$i]);
            if($i==count($file)-1) {
                $str.=$path;
            }else {
                $str.=$path."|";
            }
        }

        $article = new Article();
        $article->updateArticle($id,$category,$title,$name,$str,$content);

        return redirect('/index');

    }

//    删除数据
    public function delete(Request $request){
        $id = $request->id;
        $delArticle = new Article();
        $delArticle->deleteOne($id);
        return redirect('/index');
    }

//   获取分类信息
    public function category(Request $request){
        $parentid = $request->parentid;
        $data = Category::where('parent_id',$parentid)->get();
        return $data;
    }

//    获取分类级别
    public function getCategoryLevel(Request $request){

//        获取文章id
        $articleId = $request->articleid;
//        根据id 获取文章信息
        $article = Article::where('id',$articleId)->first();
//        获取文章对应的三级分类  也就是区id
        $articleCategoryId = $article->category_id;
//        根据区id在分类表里找到对应的id的那一条信息
        $category = Category::where('id',$articleCategoryId)->first();
//        定义数组result 获取根据id的省市县
        $result=[];
//        定义数组data  获取根据所有的省 并且根据省份获取所有的对应的市县
        $data=[];
//        得到result的第一个数组  获取区的id及名字
        $result[0] = array(
          'id'=>$category->id,
          'name'=>$category->name
        );
//        判断 如果有值 就根据父id查上一级市的信息
        if ($result){
//            获取区的父id
            $categoryParent = $category->parent_id;
//            根据区的父id 获取上一级市的信息
            $category = Category::where('id',$categoryParent)->first();
//            得到第二个result数组 获取市的id和名字
            $result[1] = array(
                'id'=>$category->id,
                'name'=>$category->name
            );
        }
//        判断 如果有值 就根据父id查上一级省的id
        if ($result){
//            获取市的父id
            $categoryParent = $category->parent_id;
//            根据市的父id 获取省的信息
            $category = Category::where('id',$categoryParent)->first();
//            得到result第三个数组 获取省的id 和名字
            $result[2] = array(
                'id'=>$category->id,
                'name'=>$category->name
            );
        }

//        找到parent_id=null的数据  就是所有省的数据
        $category = Category::where('parent_id',null)->get();
//        进行for循环  将所有省的数据遍历 把省的的id和名字放到第一个data数组对应的id和name里面
        for ($i=0;$i<count($category);$i++){
            $data[0][$i]['id'] = $category[$i]['id'];
            $data[0][$i]['name'] = $category[$i]['name'];
        }
//        echo $articleCategoryId;
//        根据区id 找到对应parent_id  也就是这个区对应的市id
        $cityid = Category::where('id',$articleCategoryId)->first()->parent_id;
//        根据市id 找到对应的parent_id 也就是这个市对应的省id
        $proviceid = Category::where('id',$cityid)->first()->parent_id;
//        根据省id取出这个省对应的所有的市的值
        $citys = Category::where('parent_id',$proviceid)->get();
//        根据市id取出这个市对应的所有的区的id
        $areas = Category::where('parent_id',$cityid)->get();
//        return $cityid;
//        将市的值保存到第二个data数组里
        $data[] = $citys;
//        将区的值保存到第三个data数组里
        $data[] = $areas;
//        循环第一个data数组 省数组
        for ($i=0;$i<count($data[0]);$i++) {
//            判断 data的第一个省数组的id==result的第三个省数组的id
            if($data[0][$i]['id']==$result[2]['id']){
//                就给这个省加一个选中字段为true
                $data[0][$i]['selected'] = true;
            }
        }
//        循环第二个data数组 市数组
        for ($i=0;$i<count($data[1]);$i++) {
//            判断 data的第二个市数组 == result的第二个市数组的id
            if($data[1][$i]['id']==$result[1]['id']){
//                就给这个市加一个selected 为true
                $data[1][$i]['selected'] = true;
            }
        }
//        循环第三个data数组 区数组
        for ($i=0;$i<count($data[2]);$i++) {
//            判断 data的第三个区数组 == result的三个区数组的id
            if($data[2][$i]['id']==$result[0]['id']){
//                就给这个区加一个为true的选中
                $data[2][$i]['selected'] = true;
            }
        }

        return $data;

//        return $result;

    }


}
