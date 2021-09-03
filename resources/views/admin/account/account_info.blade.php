@extends('layout.mainlayout')

@section('title','은지네')

@section('body')
<style>

body.modal-open {
    overflow: hidden;
}

</style>

<div class = "container-fluid">



    <div class="card mt-5 text-center">
    <div class="card-header">{{$user->name}}</div>
    <div class="card-body">이메일 : {{$user->email}}</div>
    <div class="card-body">인증 상태 : {{$user->auth}}</div>
    <div class="card-footer">
        <div class="btn-group">

@if($user->auth == 2)
                    <button type='button' class='btn btn-primary' onclick="location.href='/admin/account/authority/down/{{$user->id}}';">계정 권한 박탈</button>
                    <button type='button' class='btn btn-primary' onclick="location.href='/admin/account/authority/disable/{{$user->id}}';">계정 비활성화</button>


@elseif($user->auth == 1)
                    <button type='button' class='btn btn-primary' onclick="location.href='/admin/account/authority/up/{{$user->id}}';">계정 권한 상승</button>
                    <button type='button' class='btn btn-primary' onclick="location.href='/admin/account/authority/disable/{{$user->id}}';">계정 비활성화</button>


@elseif($user->auth == 0)
                    <button type='button' class='btn btn-primary' onclick="location.href='/admin/account/authority/up/{{$user->id}}';">계정 활성화</button>


@endif
                    <button type='button'  class='btn btn-primary' onclick="delete_account();">계정 삭제</button>

        </div>
    </div>
    </div>



</div>

@endsection



<script>

@section('addscript')

var auth = '{{$user->auth}}';

    function delete_account(){

        if(auth == "2"){
            document.getElementById("error").innerHTML = "해당 계정은 GM 계정입니다. <br>정말 삭제 하시겠습니까?";
            document.getElementById("Admin_Confirm_btn").setAttribute("onClick","'href.location=/admin/account/delete/{{$user->id}}'");
        }
        else{
            document.getElementById("error").innerHTML = "정말 삭제 하시겠습니까?";
            document.getElementById("Admin_Confirm_btn").setAttribute("onClick","href.location='/admin/account/delete/{{$user->id}}'");
        }
        $("#Admin_Warning_Modal").modal();
    }

@endsection

</script>
