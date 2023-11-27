<?php

// 必要なクラスやトレイトをインポート
namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use App\Services\EventService;

// Controllerクラスを継承したEventControllerクラス
class EventController extends Controller
{
    // イベントの一覧を表示するメソッド
    public function index()
    {
        // 現在の日付を取得
        $today = Carbon::today();

        // 予約された人数を取得するクエリ
        $reservedPeople = DB::table('reservations')
            // event_id列と、number_of_people列の合計値を取得するためにDB::raw()
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            // canceled_dateがNULLである条件の予約データを取得しています。
            ->whereNull('canceled_date')
            // event_idでグループ化して、同じevent_idを持つ予約データをまとめます。
            ->groupBy('event_id');

        // イベント一覧を取得するクエリ
        $events = DB::table('events')
            // Laravelのクエリビルダでサブクエリとの結合
            ->leftJoinSub($reservedPeople, 'reservedPeople', function($join){
                // これにより、events テーブルの id カラムと $reservedPeople サブクエリの event_id カラムを照合し、各イベントの情報に予約された人数の合計を持たせることができます。
                $join->on('events.id', '=', 'reservedPeople.event_id');
            })
            
            ->whereDate('start_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->paginate(10);

        return view('manager.events.index', compact('events'));
    }

    // 新しいイベントの作成フォームを表示するメソッド
    public function create()
    {
        return view('manager.events.create');
    }

    // 新しいイベントを保存するメソッド
    public function store(StoreEventRequest $request)
    {
        // リクエストからイベント情報を取得し、新しいイベントを作成して保存
        // ...

        // フラッシュメッセージを表示し、イベント一覧にリダイレクト
        // ...

        return to_route('events.index');
    }

    // 特定のイベントの詳細を表示するメソッド
    public function show(Event $event)
    {
        // イベントや関連するユーザーの情報を取得
        // ...

        return view('manager.events.show', compact('event', 'users', 'reservations', 'eventDate', 'startTime', 'endTime'));
    }

    // イベントの編集フォームを表示するメソッド
    public function edit(Event $event)
    {
        // 編集対象のイベントを取得し、編集可能かチェック
        // ...

        return view('manager.events.edit', compact('event', 'eventDate', 'startTime', 'endTime'));
    }

    // イベントの更新を行うメソッド
    public function update(UpdateEventRequest $request, Event $event)
    {
        // リクエストから情報を取得し、イベントを更新して保存
        // ...

        // フラッシュメッセージを表示し、イベント一覧にリダイレクト
        // ...

        return to_route('events.index');
    }

    // 過去のイベント一覧を表示するメソッド
    public function past()
    {
        // 過去のイベントを取得
        // ...

        return view('manager.events.past', compact('events'));
    }

    // イベントの削除を行うメソッド
    public function destroy(Event $event)
    {
        // 削除処理を実装
        // ...
    }
}
