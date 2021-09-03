<!DOCTYPE html>
<html lang="ko">
<head>
    <! 부트스트랩 로드>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://175.215.246.82:51/lib/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <! 부트스트랩 로드>




    <title>@yield('title')</title>



</head>

<style>
    /* 가로 스크롤 안보이게 하기 ▼▼▼ */
    html {
        overflow-x: hidden;

    }

    /* 상단바랑 메인화면 안겹치게 및 가로스크롤 안보이게 하기 ▼▼▼ */
    body { padding-top: 70px; overflow-x:hidden}

    ::-webkit-scrollbar {display:none;}



    /* 모바일 PC 글씨 크기 조절 ▼▼▼ */
    @media only screen and (max-width: 1200px)
    {
        html  {
            font-size: 0.8rem; // you can also use px here...
        }
    }

    @media only screen and (min-width: 1200px) {
        html {
            font-size: 1rem; // you can also use px here...
        }
    }
    /* 모바일에서만 리스트 안보이게 하기 ▼▼▼ */
    @media (min-width: 1200px) {
        .collapse.dont-collapse-sm {
            display: block;
            height: auto !important;
            visibility: visible;
        }
        .dont-show-pc {
            display: none;
        }
    }

    /* 리스트 움직이게 하기 ▼▼▼ */
    #scroll{
        position:relative; width:100%;
        margin: 0 auto;
    }

    /* 모바일에서 리스트 안움직이게 하기 ▼▼▼ */
    @media only screen and (max-width: 1200px)
    {
        #scroll{
            position:static;

        }
    }




</style>

<body>



<!상단바>
<nav class="navbar navbar-expand-xl navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/">은지네</a>

    @if (Auth::check())
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/mypage">내정보</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/login/logout">로그아웃</a>
                    </div>

                </li>
            </ul>
        </div>
    @else
        <ul class="navbar-nav ml-auto">
            <button type="button" class="btn btn-primary active" onclick="location.href='/signin'">로그인</button>
        </ul>
    @endif


</nav>
<!상단바>


<! 컨텐츠 선택시 링크로 이동>
<script>
    //cursor:pointer
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });

</script>
<! 컨텐츠 선택시 링크로 이동>




<! 에러 출력 화면>
<div class="modal fade" id="Warning_Modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">경고</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                {!!  $errors->first() !!}
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">닫기</button>
            </div>

        </div>
    </div>
</div>



@if ($errors->any())
    <script>$("#Warning_Modal").modal();</script>
@endif

<! 에러 출력 화면>







@section('body')

@show







<! 컨텐츠 선택 상자 마우스 포인터 변경>
<script>

    $('.clickable-row').css({
        cursor: "pointer"
    });

</script>
<! 컨텐츠 선택 상자 마우스 포인터 변경>



<script>
    /* 리스트 움직이게 하기 ▼▼▼ */

    $(window).scroll(function(){
        var position = $(document).scrollTop();
        $("#scroll").css('top',  position );
    });

</script>

<script>
    @section('addscript')

    @show
</script>


</body>
</html>

