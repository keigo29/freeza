<?php
// namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use PragmaRX\Google2FA\Google2FA;


// class LoginController extends Controller
// {
//     protected $redirectTo = '/login';
//     public function authenticate(Request $request)
//     {

//         $email = $request->input('email');
//         $password = $request->input('password');
//         $secretKey = $request->input('secret_key');

//         $credentials = ['email' => $email, 'password' => $password];

//         if (Auth::once($credentials)) {
//             $user = Auth::user();
//             if ($user->g2fa_key) {
//                 $g2fa = new Google2FA();
//                 if (!$g2fa->verifyKey($user->g2fa_key, $secretKey)) {
//                     return redirect()->route('login');
//                 }
//                 Auth::attempt($credentials);
//             }
//             return redirect()->intended($this->redirectTo);
//         }

//         return redirect()->route('login');
//     }
// }
