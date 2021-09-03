<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use App\Models\board\Post;
use App\Models\board\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MypageController extends Controller
{
    //

    function index(){
        return view('mypage.index');
    }

    function changepwd(Request $request){

        $this->validate($request,[
            'new_password'=>'required|min:4',
        ]);

        if (! Hash::check($request->input('password'), $request->user()->password)) {
            return back()->withErrors(
                '현재 비밀번호가 일치하지 않습니다.'
            );


        }
        User::where('id',auth()->id())->update(['password' => bcrypt($request->input('new_password'))]);


        return redirect('/mypage');
    }

    function myPost(Request $request){

        //$posts = Post::where('user_id',auth()->id())->paginate(15);

        //return view('mypage.post',compact('posts'));


        if($request->has('search') && ($request->input('search') != '')){

            $posts = Post::where([['title', 'like', '%'.$request->input('search').'%'],['user_id','=',auth()->id()]])->paginate(15);

        }
        else{
            $posts = Post::where('user_id',auth()->id())->paginate(15);
        }

        Paginator::useBootstrap();

        return view('mypage.post',compact('posts'));

    }

    function myComment(Request $request){

        //$posts = Comment::where('board_comments.user_id',auth()->id())->join('board_posts','board_posts.id', '=','board_comments.post_id')->paginate(15);

        /*$posts = Comment::join('board_posts','board_posts.id', '=','board_comments.post_id')->where('title', 'like', '%'.$request->input('search').'%')->whereIn('board_comments.id',function ($query){
            $query->select(DB::raw('max(board_comments.id)'))->from('board_comments')->groupBy('post_id');
        })->orderby('board_posts.id','desc')->paginate(15);*/

        //$posts = DB::select("SELECT * from board_comments where id in (select max(id) from board_comments group by post_id)")->paginate(15);

        //echo $posts[0]->title;

        if($request->has('searchoption') && $request->has('search') && ($request->input('search') != '')){
            if($request->input('searchoption') == 'title') {
                $posts = Comment::select('board_posts.id','title','board_posts.created_at','views')->join('board_posts','board_posts.id', '=','board_comments.post_id')->where('title', 'like', '%'.$request->input('search').'%')->whereIn('board_comments.id',function ($query){
                    $query->select(DB::raw('max(board_comments.id)'))->from('board_comments')->groupBy('post_id');
                })->orderby('board_posts.id','desc')->paginate(15);
            }elseif($request->input('searchoption') == 'user_id'){
                $posts = Comment::select('board_posts.id','title','board_posts.created_at','views')->join('board_posts','board_posts.id', '=','board_comments.post_id')->join('users','users.id', '=','board_comments.user_id')->where('users.name', 'like', '%'.$request->input('search').'%')->whereIn('board_comments.id',function ($query){
                    $query->select(DB::raw('max(board_comments.id)'))->from('board_comments')->groupBy('post_id');
                })->orderby('board_posts.id','desc')->paginate(15);
            }
        }
        else{
            $posts = Comment::select('board_posts.id','title','board_posts.created_at','views')->join('board_posts','board_posts.id', '=','board_comments.post_id')->whereIn('board_comments.id',function ($query){
                $query->select(DB::raw('max(board_comments.id)'))->from('board_comments')->groupBy('post_id');
            })->orderby('board_posts.id','desc')->paginate(15);
        }


        //var_dump($posts);
        return view('mypage.comment',compact('posts'));

    }
}
