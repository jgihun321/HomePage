<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\models\Notice;
use App\models\Video;
use App\models\Data;
use App\models\Data_Files;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //

    function index(){
        return view('admin.index');
    }



    function account(Request $request){



        if($request->has('Unauthorized') || ($request->has('search') && ($request->input('search') != ''))){
            if($request->input('Unauthorized') == 'true') {
                $users = User::where('auth','0')->paginate(20);
            }else{
                $users = User::where('name', 'like', '%'.$request->input('search').'%')->paginate(20);
            }
        }
        else{
            $users = User::orderby('id','asc')->paginate(20);
        }

        Paginator::useBootstrap();

        //echo $users;

        return view('admin.account.index',compact('users'));
    }

    function accountInfo($id){

        $user = User::where('id',$id)->first();

        return view('admin.account.account_info',compact('user'));

    }

    function accountDelete($idArray){

        $idArray = explode(',',$idArray);



        foreach($idArray as $id){
            User::where('id','=',$id)->delete();
        }


        return redirect()->back();

    }

    function accountAuthority($type,$id){

        if($type == 'up'){
            $auth = User::where('id',$id)->first()->auth + 1;
        }elseif($type == 'down') {
            $auth = User::where('id', $id)->first()->auth - 1;
        }else{
            $auth = 0;
        }

        User::where('id',$id)->update(['auth' => $auth]);

        return redirect()->back();
    }




    function noticeImgUpload(Request $request){

        $file = $request->file('upload')->store('/imgs/notice');



        $json = array();
        $json['uploaded'] = 'true';
        $json['url'] = 'http://175.215.246.82:8080/'.$file;

        //$json = array('url' => 'http://');

        return json_encode($json,JSON_UNESCAPED_SLASHES);
    }

    function noticeWrite(Request $request){
        //return view('admin.notice.write');

        if($request->input('id')){

            $notice = Notice::select('id','user_id','title','contents')->where('id',$request->input('id'))->first();

            if(auth()->user()->auth >= 2 ){
                return view('admin.notice.write',compact('notice'));
            }else{
                return redirect('/')->withErrors('잘못된 접근입니다.');
            }


        }
        return view('admin.notice.write');

    }

    function noticeStore(Request $request){
        //$id = Notice::insertGetId(['user_id' => auth()->id(),'title' => $request->input('title'), 'contents' => $request->input('contents')]);

        $notice = new Notice;

        $notice->user_id = auth()->id();
        $notice->title = $request->input('title');
        $notice->contents = $request->input('contents');

        $notice->save();

        return redirect('/notice/'.$notice->id);
    }

    function noticeRestore(Request $request, $id){
        Notice::where('id',$id)->update(['title' => $request->input('title'),'contents' => $request->input('contents')]);

        return redirect('/notice/'.$id);
    }
    function noticeDelete($id){
        Notice::where('id',$id)->delete();

        return redirect()->intended('/');
    }




    function adminVideoIndex(Request $request){

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

        Paginator::useBootstrap();

        return view('admin.video.index',compact('videos'));

    }

    function adminVideoNew(){
        return view('admin.video.add');
    }

    function adminVideoStore(Request $request){

        //$id = Video::insertGetId(['title' => $request->input('title'),'singer' => $request->input('singer'),'link' => "http://175.215.246.82:50/".rawurlencode($request->input('file'))]);

        $video = new Video;

        $video->title = $request->input('title');
        $video->singer = $request->input('singer');
        $video->link = "http://175.215.246.82:50/".rawurlencode($request->input('file'));

        $video->save();

        return redirect('/admin/video');
    }

    function adminVideoDetail($id){

        $video = Video::where('id',$id)->first();

        return view('admin.video.add',compact('video'));
    }

    function adminVideoRestore(Request $request,$id){

        $video = Video::find($id);

        $video->title = $request->input('title');
        $video->singer = $request->input('singer');

        $video->save();
        return redirect('/admin/video/'.$id);

    }

    function adminVideoDelete($id){

        Video::where('id',$id)->delete();

        Storage::delete('/imgs/thumbnail/'.$id.'.png');

        return redirect('/admin/video');

    }



    function dataWrite(Request $request){
        //return view('admin.notice.write');

        if($request->has('id')){
            $id = $request->input('id');
            $data = Data::select('id','title','contents')->where('id',$id)->first();
            $dataFiles = Data_Files::where('post_id',$id)->get();

            if(auth()->user()->auth >= 2 ){
                return view('admin.data.write',compact('data','dataFiles'));
            }else{
                return redirect('/')->withErrors('잘못된 접근입니다.');
            }


        }
        return view('admin.data.write');

    }

    function dataStore(Request $request){



        $files = $request->file('file');

        $data = new Data;

        $data->title = $request->input('title');
        $data->contents = $request->input('contents');

        $data->save();

        foreach($files as $file){
            $save = $file->store('/file/'.$data->id);

            $data_file = new Data_Files;

            $data_file->post_id = $data->id;
            $data_file->origin_name = $file->getClientOriginalName();
            $data_file->name = $save;

            $data_file->save();


        }

        return redirect('/data/'.$data->id);
    }

    function dataImgUpload(Request $request){

        $file = $request->file('upload')->store('/imgs/data');



        $json = array();
        $json['uploaded'] = 'true';
        $json['url'] = 'http://175.215.246.82:8080/'.$file;

        //$json = array('url' => 'http://');

        return json_encode($json,JSON_UNESCAPED_SLASHES);
    }

    function dataRestore(Request $request, $id){
        Data::where('id',$id)->update(['title' => $request->input('title'),'contents' => $request->input('contents')]);

        return redirect('/data/'.$id);
    }

    function dataDelete($id){
        Data::where('id',$id)->delete();

        Storage::deleteDirectory("/file/".$id);

        return redirect()->intended('/');
    }
}
