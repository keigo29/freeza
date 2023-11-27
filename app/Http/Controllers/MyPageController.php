<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Services\MyPageService;
use Carbon\Carbon;

class MyPageController extends Controller
{
    // マイページのトップページを表示するメソッド
    public function index()
    {
        // 現在ログインしているユーザーの情報を取得
        $user = User::findOrFail(Auth::id());

        // ユーザーが予約した全てのイベントを取得
        $events = $user->events;

        // 今日以降の予約済みイベントを取得するサービスを呼び出し
        $fromTodayEvents = MyPageService::reservedEvent($events, 'fromToday');

        // 過去の予約済みイベントを取得するサービスを呼び出し
        $pastEvents = MyPageService::reservedEvent($events, 'past');

        // デバッグ用に取得したデータを表示
        // dd($user, $events, $fromTodayEvents, $pastEvents);

        // マイページのビューを表示する際、データをコンパクトにして渡す
        return view('mypage/index', compact('fromTodayEvents', 'pastEvents'));
    }

    // 特定のイベントの詳細を表示するメソッド
    public function show($id)
    {
        // 指定されたIDのイベントを取得
        $event = Event::findOrFail($id);

        // ユーザーの予約情報を取得（最新の予約を取得）
        $reservation = Reservation::where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->latest()
            ->first();

        // イベント詳細のビューを表示する際、データをコンパクトにして渡す
        return view('mypage/show', compact('event', 'reservation'));
    }

    // イベントのキャンセルを行うメソッド
    public function cancel($id)
    {
        // 指定されたIDのイベント予約を取得（最新の予約を取得）
        $reservation = Reservation::where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->latest()
            ->first();

        // キャンセルした日時を設定して保存
        $reservation->canceled_date = Carbon::now()->format('Y-m-d H:i:s');
        $reservation->save();

        // キャンセル成功のフラッシュメッセージを表示
        session()->flash('status', 'キャンセルできました');

        // ダッシュボードにリダイレクト
        return to_route('dashboard');
    }
}
