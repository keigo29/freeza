<?php
use PragmaRX\Google2FA\Google2FA; // 追加

class RegisterController extends Controller
{
    protected function create(array $data)
    {
        // SecretKeyを生成
        $g2fa = new Google2FA();
        $key = $g2fa->generateSecretKey();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'g2fa_key' => $key, // カラムに登録
        ]);
    }
}