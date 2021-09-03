@extends('layout.mainlayout')

@section('title','은지네')

@section('body')
<div class = "container-fluid mt-5">
    <div class="table-responsive">

        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ml-3 bi bi-search dont-show-pc float-right form-inline" viewBox="0 0 16 16" data-toggle="modal" data-target="#Mobile_Search_Modal">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>

    <div class = "float-left form-inline">
            <button class="btn btn-primary ml-2" disabled = 'disabled' id='del' onclick="javascript:delete_account();">삭제</button>
        </div>

    <div class = "collapse dont-collapse-sm" id = "mobile-search">


        <div class = "float-right form-inline">
            <form action="/admin/account" method="GET">
                <input type="search" class="form-control" placeholder="아이디" id="search" name = "search">

                <button type="submit" class="btn btn-primary ml-2">검색</button>
            </form>
            <form action="/admin/account" method="GET">
                <input type = "hidden" name = "Unauthorized" value = "true">
                <button type="" class="btn btn-primary ml-2">비활성화 계정만 보기</button>
            </form>
        </div>

    </div>



        <table class="table table-hover mt-5">


            <thead>
            <tr>
                <th width = "2%"><input type="checkbox" id="all"></th>
                <th width = "10%">번호</th>
                <th width = "20%">아이디</th>
                <th width = "58%">이메일</th>
                <th width = "10%">인증 상태</th>
            </tr>
            </thead>

            <tbody>

@foreach($users as $user)
            <tr>

                <td><input type = "checkbox" name="data" id="{{$user->id}}"></td>
                <td class='clickable-row' data-href='/admin/account/{{$user->id}}'>{{$user->id}}</td>
                <td class='clickable-row' data-href='/admin/account/{{$user->id}}'>{{$user->name}}</td>
                <td class='clickable-row' data-href='/admin/account/{{$user->id}}'>{{$user->email}}</td>
                <td class = 'text-center clickable-row' data-href='/admin/account/{{$user->id}}'>{{$user->auth}}</td>

            </tr>
@endforeach

            </tbody>
        </table>
    </div>




</div>
<div class = 'container'>

    <ul class="pagination justify-content-center" style="margin:50px 0">
        @if(isset($_GET['search']))
            {{$users->onEachSide(2)->appends(['search' => $_GET['search']])->links()}}
        @else
            {{$users->onEachSide(2)->links()}}
        @endif
    </ul>

</div>
@endsection

<! 계정 삭제 링크 지정 스크립트>
<script>

    @section('addscript')

    var del_url;

function delete_account(){
    $("#Admin_Warning_Modal").modal();

    document.getElementById("error").innerHTML = "정말 삭제 하시겠습니까?";
    document.getElementById("Admin_Confirm_btn").setAttribute("onClick","href.location='/admin/account/delete/" + del_url + "'");
    //location.href = "/admin/account/delete/" + del_url;
}

function SetDelURL(url){
    del_url = url;
}
</script>
<! 계정 삭제 링크 지정 스크립트>

<! 체크박스 선택 스크립트>
<script>

var del_number ="";

$(document).ready(function(){
    $("#all").change(function(){
        if($("#all").is(":checked")){
            $('input[type=checkbox]').prop('checked', true);
        }else{
            $('input[type=checkbox]').prop('checked', false);
        }
    });

    $("input[type=checkbox]").change(function(){
        if($("input[type=checkbox]").is(":checked")){
            $("#del").removeAttr("disabled");
            for(var i = 0; i < 30 ;i ++){
                if($($('input[name=data]').eq(i)).is(":checked")){
                    del_number += $('input[name=data]').eq(i).attr('id') + ",";
                }
            }
            SetDelURL(del_number);
            del_number = "";

        }else{
            $("#del").attr('disabled', 'disabled');
        }
    });
});

document.getElementById("search_modal_body").innerHTML = "<select class='form-control' name = 'searchoption' disabled><option>아이디</option></select><br><input type='search' class='form-control' placeholder='' id='search' name = 'search'>";


@endsection
</script>
<! 체크박스 선택 스크립트>
