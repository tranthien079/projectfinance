<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Events\UserCreated;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
       if(Auth::id() > 0) 
       {
        return redirect()->route('dashboard.index');
       }
       return view('auth.login');
    }
    public function login(AuthRequest $request) {
        $credentials =[
            'email' => $request->input('email'), 
            'password' =>$request->input('password')
        ];
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index')->with('success','Đăng nhập thành công');
        }
       return redirect()->route('auth.signin')->with('error','Email hoặc mật khẩu không chính xác');
 
    }

    public function logout(Request $request) {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect()->route('auth.signin');
    }

    public function signup(AuthRequest $request)
    {
    $request->validate([
        'fname' => 'required|string',
        'lname' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'fname' => $request->input('fname'),
        'lname' => $request->input('lname'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
    ]);

    event(new UserCreated($user));

    // Đăng nhập người dùng ngay sau khi đăng ký
    // auth()->attempt($request->only('email', 'password'));

    return redirect()->route('auth.signin')->with('success','Tạo tài khoản thành công');; // Điều hướng sau khi đăng ký thành công
    }

    public function setting() {
        $title      = __('pages.profile-menu.settings');
        $user       = Auth::user();
        $timezones  = DB::table("timezones")->get();
        $currencies = DB::table("currencies")->get();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $categories = DB::table('categories')->where('user',$user->id)->orderByDesc("id")->get();
        return view('auth.setting', compact("user", "title", "timezones", "currencies","accounts","categories"));
    }
}
