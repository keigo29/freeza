<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // ダッシュボードを表示するメソッド
    public function dashboard()
    {
        return view('dashboard');
    }

    // イベントの詳細を表示するメソッド
    public function detail($id)
    {
        // 指定されたIDのイベントを取得
        $event = Event::findOrFail($id);

        // 予約された人数を取得
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNull('canceled_date')
            ->groupBy('event_id')
            ->having('event_id', $event->id)
            ->first();

        // 予約可能な人数を計算
        if (!is_null($reservedPeople)) {
            $reservablePeople = $event->max_people - $reservedPeople->number_of_people;
        } else {
            $reservablePeople = $event->max_people;
        }

        // ログインユーザーのイベント予約情報を取得
        $isReserved = Reservation::where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->where('canceled_date', '=', null)
            ->latest()
            ->first();

        // イベント詳細ページを表示する際、データをコンパクトにして渡す
        return view('event-detail', compact('event', 'reservablePeople', 'isReserved'));
    }

    // イベントの予約を行うメソッド
    public function reserve(Request $request)
    {
        // 指定されたIDのイベントを取得
        $event = Event::findOrFail($request->id);

        // 予約された人数を取得
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->whereNull('canceled_date')
            ->groupBy('event_id')
            ->having('event_id', $event->id)
            ->first();

        // 予約可能な人数を確認して予約を作成するか判断
        if (is_null($reservedPeople) || $event->max_people >= $reservedPeople->number_of_people + $request->reserved_people) {
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $request['id'],
                'number_of_people' => $request['reserved_people'],
            ]);

            // フラッシュメッセージを表示し、ダッシュボードにリダイレクト
            session()->flash('status', '登録完了');
            return to_route('dashboard');
        } else {
            // 予約できない旨のメッセージを表示し、ダッシュボードを再表示
            session()->flash('status', 'この人数は予約できません。');
            return view('dashboard');
        }
    }
}
