<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // コントローラーメソッドより先に読み込まれるメソッド
    public function boot()
    {
        view()->composer('*',function($view){
            // viewに値を渡す
            // ログイン中のユーザー情報
            $user = Auth::user();
            // dd($user['id']);
            // メモ一覧
            $memoModel = new Memo();
            $memos = $memoModel->myMemo(Auth::id());

            // タグ一覧
            $tagModel = new Tag();
            $tags = $tagModel->where('user_id',Auth::id())->get();            
            
            $view->with('user',$user)->with('memos',$memos)->with('tags',$tags);
        });
    }
}
