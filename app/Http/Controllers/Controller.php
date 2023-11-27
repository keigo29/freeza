<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // アクセス権限関連のリクエスト認可を行うためのトレイト
use Illuminate\Foundation\Bus\DispatchesJobs; // ジョブのディスパッチ（送信）を行うためのトレイト
use Illuminate\Foundation\Validation\ValidatesRequests; // リクエストのバリデーション（検証）を行うためのトレイト
use Illuminate\Routing\Controller as BaseController; // Laravelのデフォルトのベースコントローラー

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; // 上記でインポートしたトレイトを使用
}
