@extends('layout.nolistlayout')

@section('title',"은지네")

@section('body')


<div class = "row d-flex justify-content-center align-items-center">

    <div class = "col-sm-6 mt-3">
        <div class="card center-block">
            <article class="card-body">
            <h4 class="card-title mb-4 mt-1">비밀번호 변경</h4>
                <form  method="post">
                    @csrf

                    <div class="form-group">
                        <label>현재 비밀번호</label>
                        <input class="form-control" placeholder="현재 비밀번호" name="password" id="password" type="password" tabindex="1">



                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <label>새 비밀번호</label>
                        <input class="form-control" placeholder="새 비밀번호" name="new_password" id="new_password" type="password" tabindex="2">

                        <div id ='password-valid'></div>


                    </div> <!-- form-group// -->
                    <div class="form-group">
                    <label>새 비밀번호 확인</label>
                        <input class="form-control" placeholder="새 비밀번호 확인" name="pw_check" id="new_password_check" type="password" tabindex="3">

                        <div class='valid-feedback'>비밀번호가 일치합니다.</div>
                        <div class='invalid-feedback'>비밀번호를 확인해 주세요.</div>

                    </div> <!-- form-group// -->



                    <div class="form-group">
                        <button id = 'submit' type="submit" class="btn btn-primary btn-block " tabindex="4" disabled="disabled"> 확인 </button>
                    </div> <!-- form-group// -->
                </form>
            </article>
        </div> <!-- card.// -->
    </div>
</div>
@endsection



<script>
@section('addscript')

var check_data = [0,0,0,0];

var validations ={
    email: [/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/, 'Please enter a valid email address']
};


function button_active(){
    var count = 0;
    for(var i = 0; i < 2; i ++){
        if(check_data[i] == 1){
            count++;
        }
    }
    if(count == 2){
        $("#submit").removeAttr("disabled");
    }
    else{
        $("#submit").attr("disabled","disabled");
    }
}






$(document).ready(function(){

    $('#new_password').keyup(function(){
        var pw = $("#new_password").val();
        var num = pw.search(/[0-9]/g);
        var eng = pw.search(/[a-z]/ig);
        var spe = pw.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

        if(pw.length < 8 || pw.length > 20){
            check_data[0] = 0;
            $('#password-valid').attr("class", "invalid-feedback");
            $('#new_password').addClass("is-invalid")
            $('#new_password').removeClass("is-valid");
            $('#password-valid').html('8자리 ~ 20자리 이내로 입력해주세요.');
        }else if(pw.search(/\s/) != -1){
            check_data[0] = 0;
            $('#password-valid').attr("class", "invalid-feedback");
            $('#new_password').addClass("is-invalid")
            $('#new_password').removeClass("is-valid");
            $('#password-valid').html('비밀번호는 공백 없이 입력해주세요.');

        }else if(num < 0 || eng < 0 || spe < 0 ){
            check_data[0] = 0;
            $('#password-valid').attr("class", "invalid-feedback");
            $('#new_password').addClass("is-invalid")
            $('#new_password').removeClass("is-valid");
            $('#password-valid').html('영문,숫자, 특수문자를 혼합하여 입력해주세요.');

        }else {
            check_data[0] = 1;
            $('#password-valid').attr("class", "valid-feedback");
            $('#new_password').removeClass("is-invalid")
            $('#new_password').addClass("is-valid");
            //document.getElementById('pw').classList.add('is-valid');
            $('#password-valid').html('사용 가능한 비밀번호 입니다.');
        }

        button_active();

    }); // end change

    $('#new_password_check').keyup(function(){
        var pw = $("#new_password").val();
        var pw_check = $("#new_password_check").val();

        if(pw == pw_check){
            check_data[1] = 1;
            $('#new_password_check').removeClass("is-invalid")
            $('#new_password_check').addClass("is-valid");
        }else{
            check_data[1] = 0;
            $('#new_password_check').removeClass("is-valid")
            $('#new_password_check').addClass("is-invalid");
        }

        button_active();

    }); // end change
});

    @endsection
</script>


