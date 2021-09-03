@extends('layout.nolistlayout')

@section('title',"은지네")

@section('body')

<div class = "row d-flex justify-content-center align-items-center h-100">
    <br><br><br><br><br><br>
    <div class = "col-sm-6 col-md-4">
        <form action="/find/id" method="post">
            @csrf
            <div class="card center-block mt-5" style="height: 18rem;">

                    <article class="card-body">

                        <div class="form-group">
                            <label>이메일</label>
                            <input name="email" id = "email" class="form-control" placeholder="이메일" tabindex="1">
                        </div> <!-- form-group// -->

                    </article>
                    <article class = "card-footer">
                        <button class="btn btn-primary btn-block" tabindex="2">아이디 찾기</button>
                    </article>

            </div> <!-- card.// -->
        </form>
    </div>

    <div class = "col-sm-6 col-md-4">
        <form action="/find/pwd" method="post">
            @csrf
            <div class="card center-block mt-5" style="height: 18rem;">

                    <article class="card-body">

                        <div class="form-group">
                            <label>아이디</label>
                            <input name="name" id = "name" class="form-control" placeholder="아이디" tabindex="3">
                        </div> <!-- form-group// -->

                        <div class="form-group">
                            <label>이메일</label>
                            <input name="email" id = "email" class="form-control" placeholder="이메일" tabindex="4">
                        </div> <!-- form-group// -->


                    </article>
                    <article class = "card-footer">
                        <button class="btn btn-primary btn-block" tabindex="5">비밀번호 찾기</button>
                    </article>
            </div> <!-- card.// -->
        </form>

    </div>



</div>
@endsection
