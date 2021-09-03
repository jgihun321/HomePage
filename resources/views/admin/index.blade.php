@extends('layout.mainlayout')

@section('title','은지네')

@section('body')

<div class = "container-fluid mt-5">
    <div class = "row">


        <div class = "col-sm-6 col-md-4">
            <div class="card mt-3">
                <div class="card-body clickable-row" data-href='/admin/account/'>계정 관리</div>
            </div>
        </div>

        <div class = "col-sm-6 col-md-4">
            <div class="card mt-3">
                <div class="card-body clickable-row" data-href='/admin/notice/write'>공지 작성</div>
            </div>
        </div>

        <div class = "col-sm-6 col-md-4">
            <div class="card mt-3">
                <div class="card-body clickable-row" data-href='admin/data/write '>자료실 글 작성</div>
            </div>
        </div>


        <div class = "col-sm-6 col-md-4">
            <div class="card mt-3">
                <div class="card-body clickable-row" data-href='admin/video '>뮤직비디오 관리</div>
            </div>
        </div>





    </div>



</div>
@endsection
