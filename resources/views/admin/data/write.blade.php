@extends('layout.mainlayout')

@section('title','은지네')

@section('body')
    <br>

    @if(!empty($data))

        <form action="http://175.215.246.82:8080/admin/data/restore/{{$data->id}}" method = "post" enctype="multipart/form-data">

    @else

        <form method = "post" enctype="multipart/form-data">

    @endif

        @csrf

    <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/translations/ko.js"></script>

<div class="form-inline input-group">
    <input type="text" class="form-control" name="title" id="title"></input>
    <div class = "input-group-append">
        @if(!empty($data))

            <button class="btn btn-primary ml-2">글 수정</button>

        @else

            <button class="btn btn-primary ml-2">글 쓰기</button>

        @endif

    </div>
</div>

<br>

<div class="custom-file">
    <input multiple type="file" class="custom-file-input" id="file" name="file[]">
    <label class="custom-file-label" for="file" id="file_label">파일을 선택하세요</label>
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

$(".custom-file-input").on("change", function() {
    files = $(this)[0].files;
    name = '';
    for(var i = 0; i < files.length; i++)
    {
        name += '\"' + files[i].name + '\"' + (i != files.length-1 ? ", " : "");
    }
    $(".custom-file-label").html(name);
});


ClassicEditor
    .create( document.querySelector( '#contents' ),{
        ckfinder: {
            uploadUrl: 'http://175.215.246.82:8080/admin/data/img/upload',
        },
        language: 'ko'
    }
);

@if(!empty($data))

    $('#title').val('{{$data->title}}')
    $('#contents').html('{{$data->contents}}');
    @if(!empty($dataFiles))
        $('#file_label').html('@foreach($dataFiles as $file){{$file->origin_name}},@endforeach');
        $('#file').attr("disabled",true);
    @endif
@endif

@endsection
</script>
