<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class VideoController extends Controller
{
    //
    function index(Request $request){

        if($request->has('searchoption') && $request->has('search') && ($request->input('search') != '')){
            if($request->input('searchoption') == 'title') {
                $videos = Video::orderBy('id', 'desc')->where('title', 'like', '%'.$request->input('search').'%')->paginate(15);
            }elseif($request->input('searchoption') == 'singer'){
                $videos = Video::orderBy('id', 'desc')->where('singer', 'like', '%'.$request->input('search').'%')->paginate(15);
            }
        }
        else{
            $videos = Video::orderBy('id','desc')->paginate(15);
        }



        // echo $videos->nextPageUrl();

        Paginator::useBootstrap();
        //echo Storage::disk('public')->url("123.png")."<br>";

        //echo asset('/img/thumbnail/1.png');
        foreach($videos as $video)


        {
            if(!Storage::exists('/imgs/thumbnail/'.$video->id.'.png'))
            {

                echo exec("F:\\Web\\Nginx-web\\storage\\app\\public\\lib\\ffmpeg\\bin\\ffmpeg -i ".$video->link." -an -ss 00:00:10 -an -s 1920x1080 -an -r 2 -vframes 1 -y F:/Web/Nginx-web/storage/imgs/thumbnail/".$video->id.".png");
            } else{
                continue;
            }
        }


        return view('video.index',compact('videos'));

    }

    function play($id){
        return view('video.play')->with('video', Video::where('id',$id)->first());
    }

    function randomPlay(Request $request){

        $list = Video::get();

       return view('video.play',compact('list'));
    }

}
