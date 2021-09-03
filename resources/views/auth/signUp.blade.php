@extends('layout.nolistlayout')

@section('title',"은지네")

@section('body')


<div class = "row d-flex justify-content-center align-items-center">

    <div class = "col-sm-6 mt-3">
        <div class="card center-block">
            <article class="card-body">
            <h4 class="card-title mb-4 mt-1">회원가입</h4>
                <form action="/signup" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>아이디</label>
                        <input name="name" id = "name" class="form-control" placeholder="아이디" tabindex="1">

                        <div class='valid-feedback'>사용 가능한 아이디 입니다.</div>
                        <div class='invalid-feedback'>사용 불가능한 아이디 입니다.</div>

                    </div> <!-- form-group// -->

                    <div class="form-group">
                        <label>이메일</label>
                        <input type = "email" name="email" id = "email" class="form-control" placeholder="이메일" tabindex="2">

                        <div class='valid-feedback'>사용 가능한 이메일 입니다.</div>
                        <div class='invalid-feedback'>이메일 형식이 아닙니다.</div>

                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <label>비밀번호</label>
                        <input class="form-control" placeholder="비밀번호" name="password" id="password" type="password" tabindex="3">

                        <div id ='password-valid'></div>


                    </div> <!-- form-group// -->
                    <div class="form-group">
                    <label>비밀번호 확인</label>
                        <input class="form-control" placeholder="비밀번호" name="pw_check" id="password_check" type="password" tabindex="4">

                        <div class='valid-feedback'>비밀번호가 일치합니다.</div>
                        <div class='invalid-feedback'>비밀번호를 확인해 주세요.</div>

                    </div> <!-- form-group// -->



                    <div class="form-group">
                        <button id = 'submit' type="submit" class="btn btn-primary btn-block "disabled="disabled" tabindex="5"> 회원가입 </button>
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

function id_check(bool) {
    if(bool == true) {
        $('#name').removeClass("is-invalid")
        $('#name').addClass("is-valid");
        check_data[0] = 1;
    }
    else {
        $('#name').removeClass("is-valid")
        $('#name').addClass("is-invalid");
        check_data[0] = 0;
    }
    button_active();
}

function button_active(){
    var count = 0;
    for(var i = 0; i < 4; i ++){
        if(check_data[i] == 1){
            count++;
        }
    }
    if(count == 4){
        $("#submit").removeAttr("disabled");
    }
    else{
        $("#submit").attr("disabled","disabled");
    }
}






$(document).ready(function(){
    $('#name').keyup(function(){
        if ( $('#name').val().length > 6) {
            var id = $(this).val();
            // ajax 실행  is-valid
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type : 'POST',
                url : '/signup/idcheck',
                dataType: 'json',
                data:
                {name : id},
                success : function(result) {
                    //console.log(result);
                    if (result == true) {
                        id_check(true);
                    } else {
                        id_check(false);
                    }
                }

            }); // end ajax
        }else{
            id_check(false);
        }
    });

    $("input[type=email]").keyup( function(){
        validation = new RegExp(validations['email'][0]);
        if (validation.test(this.value)){
            check_data[1] = 1;
            $('#email').removeClass("is-invalid")
            $('#email').addClass("is-valid");
        } else {
            check_data[1] = 0;
            $('#email').removeClass("is-valid")
            $('#email').addClass("is-invalid");
        }
        button_active();
    }); // end change

    $('#password').keyup(function(){
        var pw = $("#password").val();
        var num = pw.search(/[0-9]/g);
        var eng = pw.search(/[a-z]/ig);
        var spe = pw.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

        if(pw.length < 8 || pw.length > 20){
            check_data[2] = 0;
            $('#password-valid').attr("class", "invalid-feedback");
            $('#password').addClass("is-invalid")
            $('#password').removeClass("is-valid");
            $('#password-valid').html('8자리 ~ 20자리 이내로 입력해주세요.');
        }else if(pw.search(/\s/) != -1){
            check_data[2] = 0;
            $('#password-valid').attr("class", "invalid-feedback");
            $('#password').addClass("is-invalid")
            $('#password').removeClass("is-valid");
            $('#password-valid').html('비밀번호는 공백 없이 입력해주세요.');

        }else if(num < 0 || eng < 0 || spe < 0 ){
            check_data[2] = 0;
            $('#password-valid').attr("class", "invalid-feedback");
            $('#password').addClass("is-invalid")
            $('#password').removeClass("is-valid");
            $('#password-valid').html('영문,숫자, 특수문자를 혼합하여 입력해주세요.');

        }else {
            check_data[2] = 1;
            $('#password-valid').attr("class", "valid-feedback");
            $('#password').removeClass("is-invalid")
            $('#password').addClass("is-valid");
            //document.getElementById('pw').classList.add('is-valid');
            $('#password-valid').html('사용 가능한 비밀번호 입니다.');
        }
        button_active();

    }); // end change

    $('#password_check').keyup(function(){
        var pw = $("#password").val();
        var pw_check = $("#password_check").val();

        if(pw == pw_check){
            check_data[3] = 1;
            $('#password_check').removeClass("is-invalid")
            $('#password_check').addClass("is-valid");
        }else{
            check_data[3] = 0;
            $('#password_check').removeClass("is-valid")
            $('#password_check').addClass("is-invalid");
        }
        button_active();

    }); // end change
});

    @endsection
</script>


