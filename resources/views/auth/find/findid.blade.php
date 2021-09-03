@extends('layout.nolistlayout')

@section('title',"은지네")

@section('body')


    <div class = "row d-flex justify-content-center align-items-center h-100">
        <div class = "col-sm-6 col-md-4">
            <form action="/find/id" method="post">
                @csrf
                <div class="card center-block mt-5" style="height: 18rem;">

                    <article class="card-body">

                        <div class="form-group">
                            <center>
                                <label><h4>해당 이메일로 가입된 아이디</h4></label>
                                    <br><br>
                                @foreach($users as $user)
                                    <label>{{substr($user->name,0,2)."***".substr($user->name,strlen($user->name)-2,2)}}</label><br>
                                @endforeach
                            </center>
                        </div> <!-- form-group// -->

                        <button type="button" class="btn btn-primary btn-block" tabindex="3" onClick="location.href='/find'">비밀번호 찾기</button>

                    </article>


                </div> <!-- card.// -->
            </form>
        </div>
    </div>
@endsection
