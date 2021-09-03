<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //


    function store(Request $request){

        $this->validate($request,[
            'name'=>'required|unique:users',
            'password'=>'required|min:4',
            'email'=>'required',
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        if(sizeof(User::where('name',$name)->get())<1) {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)]);
            return redirect('/')->withErrors('관리자가 승인할 때 까지 기다려주세요.');
        }else{
            return 123;
        }
    }


    function idcheck(Request $request){
        if (sizeof(User::where('name',$request->name)->get()) < 1)
            return 1;
        else
            return 0;
    }

    function login(Request $request){


        $credentials = $request->only('name', 'password');

        $user = User::where('name',$request->name)->first();

        if(auth()->attempt($credentials)) {

            if($user->auth > 0){
                auth()->loginUsingId($user->id);



                return redirect()->intended('/');
            }else{
                auth()->logout();
                return redirect('/')->withErrors(['인증되지 않은 계정입니다 관리자에게 문의해주세요']);
            }

        }

        else
            return redirect('/signin')->withErrors(['아이디와 비밀번호를 확인해주세요']);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/');
        }
    }

    function findId(Request $request){


         $users = User::where('email',$request->input('email'))->get();

         if(!empty($users[0]->name)){
             return view('auth.find.findid',compact('users'));
         }else{
             return back()->withErrors('해당 정보로 가입된 유저가 없습니다.');
         }


    }

    function findPwd(Request $request){


            $user = User::where([['name','=',$request->input('name')],['email','=',$request->input('email')]])->first();

            if(!empty($user->name)){

                $token = Str::random(20);

                $mail_user = array( 'email' => $request->input('email'), 'name' => '은지네' );

                $data = array( 'token' => $token, 'id' => $user->id );



                //return time();
                User::where('id',$user->id)->update(['password_reset_token' => $token,'password_reset_token_created_at' => now()]);
                Mail::send('mail.findPwd',$data,function ($message) use ($mail_user){
                    $message->from('apdmswl321@gmail.com','은지네');
                    $message->to($mail_user['email'],$mail_user['name'])->subject('비밀번호 찾기 인증 메일');
                });
                return redirect('/')->withErrors('입력하신 이메일로 인증 메일이 발송되었습니다.<br>메일을 확인해 주세요.');

            }else{
                return back()->withErrors('해당 정보로 가입된 유저가 없습니다.');
            }
    }

    function mailCheck($id,$token){

        $user = User::where([['id','=',$id],['password_reset_token','=',$token]])->first();

        if(!empty($user->id)){
            if(!(strtotime(now()) - strtotime($user->password_reset_token_created_at) > 36400)){
                return view('auth.find.changepwd');
            }else{
                User::where([['id','=',$id],['password_reset_token','=',$token]])->update(['password_reset_token' => null,'password_reset_token_created_at' => null]);
                return redirect('/')->withErrors("인증이 만료된 토큰입니다. 다시 시도해 주세요");
            }
        }else{
            return redirect('/')->withErrors("잘못된 접근입니다.");
        }


    }

    function changePwd(Request $request,$id,$token){

        $user = User::where([['id','=',$id],['password_reset_token','=',$token]])->first();

        $this->validate($request,[
            'new_password'=>'required|min:4',
        ]);

        if(!empty($user->id)){
            if(!(strtotime(now()) - strtotime($user->password_reset_token_created_at) > 36400)){
                User::where('id',$id)->update(['password' => bcrypt($request->input('new_password'))]);
                User::where('id',$id)->update(['password_reset_token' => null,'password_reset_token_created_at' => null]);

                return redirect('/signin')->withErrors("비밀번호가 정상적으로 변경되었습니다.");
            }else{
                User::where([['id','=',$id],['password_reset_token','=',$token]])->update(['password_reset_token' => null,'password_reset_token_created_at' => null]);
                return redirect('/')->withErrors("인증이 만료된 토큰입니다. 다시 시도해 주세요");
            }
        }else{
            return redirect('/')->withErrors("잘못된 접근입니다.");
        }
    }


}
