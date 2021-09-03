@extends('layout.mainlayout')

@section('title',"은지네")

@section('body')
    <div class = "row">
        <div class = "col-sm-6 mt-3">
            <div class = "card">
                <div class="card-header">
                공지사항
                    <span class="float-right">
                        <a href = "/notice" class = "small">more</a>
                    </span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($notices as $notice)
                            <li class="list-group-item list-group-item-action">

                                <a href ="/notice/{{$notice->id}}">{{$notice->title}}

                                    <span class="float-right">

                                </span>

                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class = "col-sm-6 mt-3">
            <div class = "card">
                <div class="card-header">
                    게시판
                    <span class="float-right">
                        <a href = "/post" class = "small">more</a>
                    </span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">

                        @foreach($posts as $post)
                            <li class="list-group-item list-group-item-action">

                                <a href ="/post/{{$post->id}}">{{$post->title}}

                                    <span class="float-right">
                                    {{$post->name}}
                                </span>

                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

        <div class = "col-sm-6 mt-3">
            <div class = "card">
                <div class="card-header">
                    자료실
                    <span class="float-right">
                        <a href = "/data" class = "small">more</a>
                    </span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($datas as $data)
                            <li class="list-group-item list-group-item-action">

                                <a href ="/data/{{$data->id}}">{{$data->title}}

                                    <span class="float-right">

                                </span>

                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class = "col-sm-6 mt-3">
            <div class = "card">
                <div class="card-header">
                    뮤직비디오
                    <span class="float-right">
                        <a href = "/video" class = "small">more</a>
                    </span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($videos as $video)
                            <li class="list-group-item list-group-item-action">

                                <a href ="/video/{{$video->id}}">{{$video->title}}

                                <span class="float-right">
                                    {{$video->singer}}
                                </span>

                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection



