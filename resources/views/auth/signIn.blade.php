@extends('layout.nolistlayout')

@section('title',"은지네")

@section('body')

<div class = "row d-flex justify-content-center align-items-center h-100">

    <div class = "col-sm-6 mt-3">
        <div class="card center-block">
            <article class="card-body">
            <a href="/signup" class="float-right btn btn-outline-primary">회원가입</a>
            <h4 class="card-title mb-4 mt-1">로그인</h4>
                <form action="/login" method="post">
                    @csrf
                    <div class="form-group">
                        <label>아이디</label>
                        <input name="name" id = "name" class="form-control" placeholder="아이디" tabindex="1">
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <a class="float-right" href="/find">까먹었나요?</a>
                        <label>비밀번호</label>
                        <input class="form-control" placeholder="비밀번호" name="password" id="password" type="password" tabindex="2">
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <div class="checkbox">


@if ($errors->any())
                                  <!--      <span class='text-danger float-right'>{{$errors->first()}}</span> -->
@endif
                        </div> <!-- checkbox .// -->

                    </div> <!-- form-group// -->



                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" tabindex="3"> 로그인  </button>
                    </div> <!-- form-group// -->
                </form>
            </article>
        </div> <!-- card.// -->
    </div>
</div>
@endsection
