@extends('layout.mainlayout')

@section('title','은지네')


@if(empty($video))
    @section('body')
        <br>
        <form method="post">
            @csrf
            <div class="form-group">
                <label>파일을 선택하세요</label>
                <select class="form-control" name="file" id="file" onchange="fileSelected(this.value)">
        @php

            $handle = opendir("E:/MV");

            while(($file = readdir($handle)) !== false){

                if($file == "." || $file == ".." || $file == "index.html" || $file == "web.config") {
                    continue;
                }


                echo "<option>".$file."</option>";
            }
            closedir($handle);


        @endphp
                </select>
                <br>
                <label>제목</label>
                <input type="text" class="form-control" name="title">
                <br>
                <label>가수</label>
                <input type="text" class="form-control" name="singer">
                <br>
                <button type="subbmit" class="btn btn-primary">추가</button>
                <br>
                <br>

                <label>미리보기</label><br>
                <video class="img-fluid" controls width=400 id="player" src="#" muted></video>

            </div>
        </form>


    @endsection

    <script>
    @section('addscript')

    const player = document.getElementById('player');

    player.volume = 0.2;

    function fileSelected(url){

        url = encodeURIComponent(url);


        player.src = 'http://175.215.246.82:50/' + url;
        player.play();

    }


    $(document).ready(function(){

        $('#file').on('change', function() {

            const file = this.text();

            alert(file);

            //player.src= 'http://175.215.246.82:51/' + encodeURIComponent(file);
            //alert(player.play());


        });

    });

    @endsection
    </script>

@else


    @section('body')
        <br>
        <table class="table table-borderless table-responsive">
            <tr>
                <td width="50%">
                    <video class="img-fluid" controls src="{{$video->link}}" muted autoplay nodownload></video>
                </td>
                <td width="50%">
                    <form method="post">
                        @csrf
                        <div class="form-group">
                            <label>파일을 선택하세요</label>
                            <select class="form-control" disabled>
                                <option>{{$video->link}}</option>
                            </select>
                            <br>
                            <label>제목</label>
                            <input type="text" class="form-control" name="title" value="{{$video->title}}">
                            <br>
                            <label>가수</label>
                            <input type="text" class="form-control" name="singer" value="{{$video->singer}}">
                            <br>
                            <button type="subbmit" class="btn btn-primary">수정</button>

                        </div>
                    </form>
                    <button class="btn btn-primary" onClick="location.href='/admin/video/delete/{{$video->id}}'">삭제</button>
                </td>
            </tr>
        </table>

    @endsection
@endif
