<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//home
Route::get('', [IndexController::class,'indexHome'])->name('home');

Route::get('notLogin',[IndexController::class,'notLogin'])->name('notLogin');




//getImage

Route::get('imgs/{path}',[IndexController::class,'getImage'])->where('path', '[a-zA-Z0-9\/\.]+');

Route::get('file/{path}',[IndexController::class,'getFile'])->where('path', '[a-zA-Z0-9\/\.]+\'');

//auth
Route::get('signin', function(){
    return view('auth.signIn');
});

Route::get('signup', function(){
    return view('auth.signUp');
});

Route::get('logout', function(){
    Auth::logout();
    return redirect("/");
});

Route::get('find',function(){
    return view('auth.find.find');
});

Route::get('find/{id}/{token}',[LoginController::class,'mailCheck']);

Route::post('find/{id}/{token}',[LoginController::class,'changePwd']);

Route::post('find/id',[LoginController::class,'findId']);

Route::post('find/pwd',[LoginController::class,'findPwd']);


Route::post('signup/idcheck', [LoginController::class,'idcheck']);

Route::post('signup', [LoginController::class,'store']);

Route::post('login', [LoginController::class,'login']);


//Video

Route::prefix('video')->middleware('auth')->group(function (){

    Route::get('', [VideoController::class,'index']);

    Route::get('random',[VideoController::class,'randomPlay']);

    Route::get('{id}', [VideoController::class,'play']);



});


//Notice

Route::prefix('notice')->group(function (){

    Route::get('{id}',[NoticeController::class,'notice']);

    Route::get('',[NoticeController::class,'index']);

});




//Board
//middleware('auth')->
Route::prefix('post')->middleware('auth','web')->group(function (){

    Route::get('', [BoardController::class,'index']);

    Route::get('write' ,[BoardController::class,'write']);

    Route::post('write',[BoardController::class,'store']);

    Route::get('delete/{id}',[BoardController::class,'delete']);

    Route::post('restore/{id}',[BoardController::class,'restore']);

    Route::post('img/upload' ,[BoardController::class ,'imgUpload']);


    Route::get('comment/delete/{id}',[BoardController::class,'commentDelete']);



    Route::get('{id}', [BoardController::class,'post']);

    Route::post('{id}',[BoardController::class,'commentStore']);



});

//data

Route::prefix('data')->middleware('auth')->group(function(){

    Route::get('',[DataController::class,'index']);

    Route::get('{id}', [DataController::class,'post']);
});

//Mypage


Route::prefix('mypage')->middleware('auth')->group(function(){

    Route::get('',[MypageController::class,'index']);

    Route::get('changepwd',function(){
        return view('mypage.changepwd');
    });

    Route::post('changepwd',[MypageController::class,'changepwd']);



    Route::get('post',[MypageController::class,'myPost']);

    Route::get('comment',[MypageController::class,'myComment']);
});

//Admin

Route::prefix('admin')->middleware('check.gm','auth')->group(function (){

    Route::get('',[AdminController::class,'index']);




    Route::get('account/authority/{type}/{id}',[AdminController::class,'accountAuthority']);

    Route::get('account/disable/{id}',[AdminController::class,'accountDisable']);

    Route::get('account/delete/{id}',[AdminController::class,'accountDelete']);

    Route::get('account/{id}',[AdminController::class,'accountInfo']);

    Route::get('account', [AdminController::class,'account']);



    Route::post('notice/write',[AdminController::class,'noticeStore']);

    Route::post('notice/restore/{id}',[AdminController::class,'noticeRestore']);

    Route::post('notice/img/upload' ,[AdminController::class ,'noticeImgUpload']);

    Route::get('notice/write',[AdminController::class,'noticeWrite']);

    Route::get('notice/{id}',[AdminController::class,'notice']);

    Route::get('notice/delete/{id}',[AdminController::class,'noticeDelete']);

    Route::get('notice',[AdminController::class,'noticeIndex']);



    Route::get('video/delete/{id}',[AdminController::class, 'adminVideoDelete']);

    Route::get('video/new',[AdminController::class,'adminVideoNew']);

    Route::post('video/new',[AdminController::class,'adminVideoStore']);

    Route::get('video/{id}',[AdminController::class,'adminVideoDetail']);

    Route::post('video/{id}',[AdminController::class,'adminVideoRestore']);

    Route ::get('video',[AdminController::class,'adminVideoIndex']);



    Route::post('data/write',[AdminController::class,'dataStore']);

    Route::post('data/restore/{id}',[AdminController::class,'dataRestore']);

    Route::get('data/write',[AdminController::class,'dataWrite']);

    Route::post('data/img/upload' ,[AdminController::class ,'dataImgUpload']);

    Route::get('data/delete/{id}',[AdminController::class,'dataDelete']);

});


