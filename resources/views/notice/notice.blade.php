
@extends('layout.postlayout')


@section('title',$notice->title)

@section('post')





    <div class = "enable-responsive-font-sizes">


        <! 게시글 정보 출력>
        <table class="table table-responsive mt-5 table-borderless">
            <thead>
            <tr>
                <th scope="col">{{$notice->id}}</th>

                <th scope="col">{{$notice->created_at}}</th>

            </tr>
        </table>

        <br>

        @if(empty(auth()->user()))

        @elseif(auth()->user()->auth >= 2)
        <div class = "float-right form-inline">
            <button class="btn btn-primary ml-2" onClick="location.href='/admin/notice/write?id={{$notice->id}}'">글 수정</button>
            <button class="btn btn-primary ml-2" onClick="location.href='/notice/delete/{{$notice->id}}'">글 삭제</button>
        </div>
        @endif
        <h4>{{$notice->title}}</h4>

        <hr style="height:2px;color:black;">
        <br><br>

        {!! $notice->contents !!}

@endsection



<script>
@section('addscript')
    $(document).ready(function(){
        $('img').addClass('img-fluid')
});
@endsection
</script>
