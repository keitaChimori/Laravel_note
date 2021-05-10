<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // ホーム画面表示(home)
    public function index()
    {
        // 全メモを取得
        $user = Auth::user();
        $memos = Memo::where('user_id',$user['id'])->where('deleted_at',null)->orderBy('updated_at','DESC')->get();
        // dd($memos);
        return view('home',compact('memos','user'));
    }

    // メモ新規登録画面表示
    public function create()
    {
        // ログイン中のユーザー情報を取得
        $user = Auth::user();
        // dd($user); 
        // 全メモを取得
        $memos = Memo::where('user_id',$user['id'])->where('deleted_at',null)->orderBy('updated_at','DESC')->get();
        return view('create',compact('user','memos'));
    }

    // メモ新規登録実行
    public function store(Request $request)
    {
        $memodata = $request->all();
        // dd($memodata);
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す


        $memo_id = Memo::insertGetId([
            'content' => $memodata['content'],
            'user_id' => $memodata['user_id'],
            'status' => "1",
        ]);
        
        // リダイレクト処理
        return redirect()->route('home');
    }

    // メモ編集画面表示
    public function edit($id)
    {
        $user = Auth::user();
        // 編集するメモデータを取得
        $memo = Memo::where('deleted_at',null)->where('user_id',$user['id'])->where('id',$id)->first();
        // dd($memo);
        // 全メモを取得
        $memos = Memo::where('user_id',$user['id'])->where('deleted_at',null)->orderBy('updated_at','DESC')->get();
        // 編集画面表示
        return view('edit',compact('memo','user','memos'));
    }

    // メモ編集実行
    public function update(Request $request, $id)
    {
        // 変更メモ内容を取得
        $input_memo = $request->all();
        // dd($input_memo);
        //データ更新
        Memo::where('id',$id)->update(['content' => $input_memo['content']]);
        // リダイレクト処理
        return redirect()->route('home');
    }
}
