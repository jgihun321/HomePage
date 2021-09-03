<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Video;
use App\Models\Notice;
use App\Models\Board\Post;
use App\Models\Data;
use App\Models\Data_Files;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    //
    function indexHome(){

        $videos = Video::orderBy('id','desc')->take(4)->get();
        $posts = Post::select('board_posts.id','user_id','title','name')->orderBy('board_posts.id','desc')->take(4)->join('users','users.id', '=','board_posts.user_id')->get();
        $notices = Notice::orderBy('id','desc')->take(4)->get();
        $datas = Data::orderby('id','desc')->take(4)->get();

        //echo $posts;
        //echo Auth::id();
        //echo Auth::user();

        //echo $Videos[0]->title;



        return view('index')->with('videos',$videos)->with('posts',$posts)->with('notices',$notices)->with('datas',$datas);


    }

    function notLogin(){
        return redirect('/')->withErrors(['로그인한 사용자만 이용할 수 있습니다.']);
    }





    function getImage($path){

        return response(Storage::get("imgs/".$path),200)->header('Content-Type','image');

    }

    function getFile($path){
        $path = "file/".$path;
        $file = Data_Files::where('name',$path)->first();
        return Storage::download($path,$file->origin_name);
    }


}
