<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Data;
use App\Models\Data_Files;

class DataController extends Controller
{
    //

    function index(Request $request){

            if($request->has('search') && ($request->input('search') != '')){
                    $posts = Data::select('id','title','created_at')->where('title', 'like', '%'.$request->input('search').'%')->orderby('id','desc')->paginate(15);
            }
            else{
                $posts = Data::select('id','title','created_at')->orderby('id','desc')->paginate(15);

            }

            Paginator::useBootstrap();

            return view('data.index',compact('posts'));
    }

    function post($id){
        $post = Data::find($id);

        $files = Data_Files::where('post_id',$id)->get();


        return view('data.post',compact('post','files'));
    }
}
