<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use Illuminate\Pagination\Paginator;

class NoticeController extends Controller
{
    //

    function index(Request $request){

       // $notices = Notice::orderBy('id','desc')->paginate(15);

        if($request->has('search') && ($request->input('search') != '')){
                $notices = Notice::select('id','title','created_at')->where('title', 'like', '%'.$request->input('search').'%')->paginate(15);
        }
        else{
            $notices = Notice::orderBy('id','desc')->paginate(15);
        }

        Paginator::useBootstrap();

        return view('notice.index',compact('notices'));
    }

    function notice($id){

        $notice = Notice::where('id',$id)->first();

        return view('notice.notice',compact('notice'));

    }
}
