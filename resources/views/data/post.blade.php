
@extends('layout.postlayout')


@section('title',$post->title)

@section('post')





    <div class = "enable-responsive-font-sizes">


        <! 게시글 정보 출력>
        <table class="table table-responsive mt-5 table-borderless">
            <thead>
            <tr>
                <th scope="col">{{$post->id}}</th>

                <th scope="col">{{$post->created_at}}</th>

                <th scope="col">{{$post->name}}</th>

            </tr>
        </table>

        <br>
        @if(auth()->user()->auth == 2)
        <div class = "float-right form-inline">
            <button class="btn btn-primary ml-2" onClick="location.href='../admin/data/write?id={{$post->id}}'">글 수정</button>
            <button class="btn btn-primary ml-2" onClick="location.href='../admin/data/delete/{{$post->id}}'">글 삭제</button>
        </div>
        @endif
        <h4>{{$post->title}}</h4>

        <hr style="height:2px;color:black;">

        @foreach($files as $file)
            <a href="../{{$file->name}}">{{$file->origin_name}}</a><br>

        @endforeach

        <hr style="height:2px;color:black;">
        <br><br>

        {!! $post->contents !!}
        <! 게시글 정보 출력>

    </div>
    <br><br>

@endsection



<script>
@section('addscript')
    $(document).ready(function(){
        $('img').addClass('img-fluid')
});

    //alert("http://175.215.246.82:8080/file/1/" + encodeURIComponent("{{$files[0]->name}}"));


@endsection
</script>
