<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo;
use App\Models\Tag;

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
        return view('create');
    }

    // メモ新規登録画面表示
    public function create()
    { 
        return view('create');
    }

    // メモ新規登録実行
    public function store(Request $request)
    {
        $memodata = $request->all();
        // dd($memodata);
        // tagの重複確認
        $exist_tag = Tag::where('name',$memodata['tag'])->where('user_id',$memodata['user_id'])->first();
        // dd($exist_tag);  
        if(empty($exist_tag['id'])){
            // タグ重複なし
            // 先にtagテーブルに挿入
            $tag_id = Tag::insertGetId(['name' => $memodata['tag'], 'user_id' => $memodata['user_id']]);
            // dd($tag_id);
        }else{
            // タグ重複あり
            $tag_id = $exist_tag['id'];
        }
        
        // memosテーブルに挿入
        $memo_id = Memo::insertGetId([
            'content' => $memodata['content'],
            'user_id' => $memodata['user_id'],
            'tag_id' => $tag_id,
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
        // 編集画面表示
        return view('edit',compact('memo'));
    }

    // メモ編集実行
    public function update(Request $request, $id)
    {
        // 変更メモ内容を取得
        $input_memo = $request->all();
        // dd($input_memo);
        //データ更新
        Memo::where('id',$id)->update(['content' => $input_memo['content'],'tag_id' => $input_memo['tag_id']]);
        // リダイレクト処理
        return redirect()->route('home');
    }

    // メモ削除
    public function delete(Request $request, $id)
    {
        // 変更メモ内容を取得
        $input_memo = $request->all();
        //メモ論理削除
        Memo::find($id)->delete();
        // リダイレクト処理
        return redirect()->route('home')->with('success','メモを削除しました！');
    }
}
