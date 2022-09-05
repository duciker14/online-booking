<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterUserController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function add(Request $request){
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'birthdate' => 'required',
            'phone' => 'required|digits:10',
            'address' => 'required',
        ]);

        $url = url()->previous();
        $referen_url = DB::table('users')->select('referen_url','id')->where('referen_url',$url)->first();
        $tokenAff = Str::random(10);
        // $token = strtoupper(Str::random(10));
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->birthdate = $request->birthdate;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        // $user->token = $token;
        if($request->has('affiliator')){
            $user->is_affiliator = 1;
            $user->referen_url = "http://127.0.0.1:8000/register?affiliator_ref=$tokenAff";
        }
        if(isset($referen_url)){
            $user->affiliator_ref = $referen_url->id;
        }

        if($user->save()){
            $timeRegister = strtotime(date('d-m-Y H:i:s'));
            $token = bin2hex($user->id . '_' . $timeRegister);
            Mail::send('emails.active-account', compact('user','token'), function($email) use($user, $token){
                $email->subject('Online Booking - Account Authentication');
                $email->to($user->email);
            });
            return redirect()->route('user.login')->with('message', 'Đăng ký thành công, vui lòng kiểm tra email của bạn để xác nhận tài khoản!');
        }
        return redirect()->back();
    }
    public function actived(User $user, $token){
        // if($user->token === $token){
        //     $user = User::where('token',$token)->update(['status' => 1, 'token'=>null, 'email_verified_at' => date('Y-m-d H:i:s')]);
            
        //     return redirect()->route('auth.login')->with('message', 'Xác thực tài khoản thành công, bạn có thể đăng nhập');
        // }else{
        //     return redirect()->route('auth.login')->with('no', 'Xác thực tài khoản thất bại');
        // }
        $tok = hex2bin($token);
        $data = explode("_", $tok);
        $id = $data[0];
        $date = date('d-m-Y H:i:s');
        $date_exp = strtotime($date);
        $time_exp = $data[1] + 64000;
        // $user = User::find($id)->first();
        if($time_exp > $date_exp){
            User::where('id',$id)->update(['status' => 1, 'email_verified_at' => date('Y-m-d H:i:s')]);
            return redirect()->route('user.login')->with('message', 'Xác thực tài khoản thành công, bạn có thể đăng nhập');
        }else{
            return redirect()->route('user.login')->with('no', 'Link xác thực đã hết hạn');
        }
    }
}
