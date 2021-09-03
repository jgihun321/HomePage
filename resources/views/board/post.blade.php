
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
        @if(auth()->id() == $post->user_id || auth()->user()->auth == 2)
        <div class = "float-right form-inline">
            <button class="btn btn-primary ml-2" onClick="location.href='/post/write?id={{$post->id}}'">글 수정</button>
            <button class="btn btn-primary ml-2" onClick="javascript:delPost()">글 삭제</button>
        </div>
        @endif
        <h4>{{$post->title}}</h4>

        <hr style="height:2px;color:black;">
        <br><br>

        {!! $post->contents !!}
        <! 게시글 정보 출력>

    </div>

@endsection


@section('comment')

            <br><br>
            <! 댓글 출력 부분>
            <table class="table table-hover">


@foreach($comments as $comment)
                <tr>
                    <td width = "20%">{{$comment->name}}</td>
                    <td width = "70%">{{$comment->comment}}</td>

                    @if($comment->user_id == auth()->id() || auth()->user()->auth == 2)
                        <td width="10%"><a href="javascript:delComment({{$comment->id}})"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                    @else
                        <td width="10%"></td>
                    @endif
                </tr>
@endforeach
            </table>
            <! 댓글 출력 부분>


            <br><br>

            <! 댓글 작성 부>

                <div class = "form-inline form-group">
                    <form method="post">

                        @csrf
                        <table width="100%" class="table table-responsive table-borderless">
                            <tr>
                                <td width="85%"><textarea cols="70%" class="form-control" type="text" name="comment" id="comment"></textarea></td>
                                <td><button class="btn btn-primary ml-2">등록</button></td>
                            </tr>
                        </table>


                    </form>
                </div>

            <! 댓글 작성 부>

@endsection

<script>
@section('addscript')
    $(document).ready(function(){
        $('img').addClass('img-fluid')
});


    function delComment(id){
        if(confirm('정말 삭제하시겠습니까?') == true){
            window.location.replace('/post/comment/delete/' + id);
        }else{
            return;
        }
    }

    function delPost(){
        if(confirm('정말 삭제하시겠습니까?') == true){
            window.location.replace('/post/delete/{{$post->id}}');
        }else{
            return;
        }
    }
@endsection
</script>
