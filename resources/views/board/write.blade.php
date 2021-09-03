@extends('layout.mainlayout')

@section('title','은지네')

@section('body')
    <br>

        @if(!empty($post))

            <form action="http://175.215.246.82:8080/post/restore/{{$post->id}}" method = "post">

        @else

            <form method = "post">

        @endif

        @csrf

    <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/translations/ko.js"></script>

<div class="form-inline input-group">
    <input type="text" class="form-control" name="title" id="title"></input>
    <div class = "input-group-append">

        @if(!empty($post))

            <button class="btn btn-primary ml-2">글 수정</button>

        @else

            <button class="btn btn-primary ml-2">글 쓰기</button>

        @endif

    </div>
</div>



    <br><br>

    <textarea name="contents" id="contents"></textarea>
    </form>

    <style>
        .ck-editor__editable{
            min-height: 400px;
        }
    </style>

@endsection


<script>
@section('addscript')



ClassicEditor
    .create( document.querySelector( '#contents' ),{
        ckfinder: {
            uploadUrl: 'http://175.215.246.82:8080/admin/notice/img/upload',
        },
        language: 'ko'
    }
);

@if(!empty($post))

$('#title').val('{{$post->title}}')
$('#contents').html('{{$post->contents}}');

    @endif

@endsection
</script>
