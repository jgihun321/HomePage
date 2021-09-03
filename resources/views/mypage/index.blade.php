@extends('layout.mainlayout')

@section('title','은지네')

@section('body')

<div class = "container-fluid mt-5">
    <div class = "row">


        <div class = "col-sm-6 col-md-4">
            <div class="card mt-3">
                <div class="card-body clickable-row" data-href='/mypage/changepwd'>비밀번호 변경</div>
            </div>
        </div>

        <div class = "col-sm-6 col-md-4">
            <div class="card mt-3">
                <div class="card-body clickable-row" data-href='/mypage/post'>게시글 관리</div>
            </div>
        </div>


        <div class = "col-sm-6 col-md-4">
            <div class="card mt-3">
                <div class="card-body clickable-row" data-href='mypage/comment '>댓글 관리</div>
            </div>
        </div>



    </div>



</div>
@endsection
