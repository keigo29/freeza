<?php
// use Illuminate\Support\Facades\Auth; // 追加
// use PragmaRX\Google2FA\Google2FA; // 追加

// class HomeController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();

//         $g2fa = new Google2FA();

//         // $g2fa->setAllowInsecureCallToGoogleApis(true);
//         $qrUrl = $g2fa->getQRCodeGoogleUrl(
//             config('app.name'),
//             $user->email,
//             $user->g2fa_key
//         );
//         return view('home', ['qr' => $qrUrl]);
//     }
// }