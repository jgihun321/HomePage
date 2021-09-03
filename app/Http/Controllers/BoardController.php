<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Board\Post;
use App\Models\Board\Comment;
use Illuminate\Support\Facades\Storage;

class BoardController extends Controller
{
    //

    function index(Request $request){

        if($request->has('searchoption') && $request->has('search') && ($request->input('search') != '')){
            if($request->input('searchoption') == 'title') {
                 $posts = Post::select('board_posts.id','title','name','views','board_posts.created_at')->orderBy('board_posts.id','desc')->join('users','users.id', '=','board_posts.user_id')->where('title', 'like', '%'.$request->input('search').'%')->paginate(15);
            }elseif($request->input('searchoption') == 'user_id'){
                 $posts = Post::select('board_posts.id','title','name','views','board_posts.created_at')->orderBy('board_posts.id','desc')->join('users','users.id', '=','board_posts.user_id')->where('name', 'like', '%'.$request->input('search').'%')->paginate(15);
            }
        }
        else{
          $posts = Post::select('board_posts.id','title','name','views','board_posts.created_at')->orderBy('board_posts.id','desc')->join('users','users.id', '=','board_posts.user_id')->paginate(15);

        }

        Paginator::useBootstrap();

        return view('board.index',compact('posts'));
    }

    function post($id){
        $post = Post::select('board_posts.id','user_id','title','contents','name','board_posts.created_at')->where('board_posts.id',$id)->join('users','users.id', '=','board_posts.user_id')->first();

        $comments = Comment::select('board_comments.id','post_id','user_id','comment','name')->where('post_id',$id)->join('users','users.id', '=','board_comments.user_id')->get();

        if($post->user_id != auth()->id() && !session()->get('readP'.$id)){
            Post::where('id',$id)->increment('views');

            session()->put('readP'.$id,true);
        }



        return view('board.post',compact('post','comments'));
    }

    function write(Request $request){

        if($request->input('id')){

            $post = Post::select('id','user_id','title','contents')->where('id',$request->input('id'))->first();

            if(auth()->id() == $post->user_id || auth()->user()->auth == 2){
                return view('board.write',compact('post'));
            }else{
                return redirect('/')->withErrors('잘못된 접근입니다.');
            }


        }
        return view('board.write');
    }

    function imgUpload(Request $request){

        $file = $request->file('upload')->store('/imgs/post');



         $json = array();
         $json['uploaded'] = 'true';
         $json['url'] = 'http://175.215.246.82:8080/'.$file;

        //$json = array('url' => 'http://');

         return json_encode($json,JSON_UNESCAPED_SLASHES);

        //return ":http:/./";

    }

    function store(Request $request){
        //$id = Post::insertGetId(['user_id' => auth()->id(),'title' => $request->input('title'), 'contents' => $request->input('contents')]);

        $post = new Post;

        $post->user_id = auth()->id();
        $post->title = $request->input('title');
        $post->contents = $request->input('contents');

        $post->save();


        return redirect('/post/'.$post->id);
    }

    function restore(Request $request, $id){
        //Post::where('id',$id)->update(['title' => $request->input('title'),'contents' => $request->input('contents')]);

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->contents = $request->input('contents');
        $post->save();


        return redirect('/post/'.$id);
    }
    function delete($id){

        $postWriter = Post::select('user_id')->where('id',$id)->first()->user_id;

        if(auth()->id() == $postWriter || auth()->user()->auth == 2){
            Post::where('id',$id)->delete();

            return redirect()->intended('/');
        }else{
            return redirect('/')->withErrors('잘못된 접근입니다.');
        }


    }


    function commentStore(Request $request,$id){
        //Comment::insert(['user_id' => auth()->id(), 'post_id' => $id,'comment' => $request->input('comment')]);

        $comment = new Comment;

        $comment->user_id = auth()->id();
        $comment->post_id = $id;
        $comment->comment = $request->input('comment');

        $comment->save();

        return redirect('/post/'.$id);
    }

    function commentDelete($id){

        $comment = Comment::find($id);

        if($comment->user_id == auth()->id()){
            $comment->delete();
            return back();
        }else{
            return redirect('/')->withErrors('잘못된 접근입니다.');
        }
    }
}
