
@extends('layout.mainlayout')

@section('title','은지네')

@section('body')
<br>



<div class = "float-right form-inline">
    <button class="btn btn-primary ml-2" onClick="location.href='/video/random'">전체 랜덤 재생</button>
</div>

<div class = "collapse dont-collapse-sm" id = "mobile-search">

        <div class = "float-right form-inline">
            <form action="/video" method="GET">
                <select class="form-control" name = "searchoption">
                    <option value = "title">제목</option>
                    <option value = "singer">가수</option>
                </select>
                <input type="search" class="form-control" placeholder="" id="search" name = "search">

                <button type="submit" class="btn btn-primary ml-2">검색</button>
            </form>
        </div>
</div>
        <br>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-3 bi bi-search dont-show-pc float-left form-inline" viewBox="0 0 16 16" data-toggle="modal" data-target="#Mobile_Search_Modal">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
</svg>
        <br><br>

    <div class = "row">



@foreach ($videos as $video)
            <div class = "col-sm-6 col-md-4">
                <div class="card clickable-row mt-3" data-href='/video/{{$video->id}}'>
                    <div class="card-img-top"><img src="/imgs/thumbnail/{{$video->id}}.png" class="img-thumbnail"></div>

                    <div class="card-body">
                        <h5>{{$video->title}}</h5>
                        <span class="float-right">
                                            <small>{{$video->singer}}</small>
                        </span>
                    </div>

                </div>
            </div>
@endforeach

    </div>
</div>

<div class = "container">

    <ul class="pagination justify-content-center" style="margin:50px 0">
@if(isset($_GET['search']))
            {{$videos->onEachSide(2)->appends(['searchoption' => $_GET['searchoption']])->appends(['search' => $_GET['search']])->links()}}
@else
            {{$videos->onEachSide(2)->links()}}
@endif

    </ul>
</div>
@endsection

<script>
@section('addscript')
    document.getElementById("search_modal_body").innerHTML = "<select class='form-control' name = 'searchoption'><option value = 'title'>제목</option> <option value = 'singer'>가수</option> </select><br><input type='search' class='form-control' placeholder='' id='search' name = 'search'>";
@endsection
</script>


