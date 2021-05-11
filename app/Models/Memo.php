<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Memo extends Model
{
    use HasFactory;
    use SoftDeletes;

    // メモ一覧表示（タグの絞り込みのアリorナシの分岐）
    public function myMemo($user_id){
        $tag = Request('tag'); //URLに「tag」があるか確認
        // dd($tag);

        if(empty($tag)){
            // タグ「tag」がなければ、その人が持っているメモを全て取得
            return $this::select('memos.*')->where('user_id', $user_id)->where('status', 1)->get();      
        }else{
        // タグ「tag」の指定があればタグで絞る ->wher(tagがクエリパラメーターで取得したものに一致)
          $memos = $this::select('memos.*')
              ->leftJoin('tags', 'tags.id', '=','memos.tag_id')
              ->where('tags.name', $tag)
              ->where('tags.user_id', $user_id)
              ->where('memos.user_id', $user_id)
              ->where('status', 1)
              ->get();
          return $memos;
        }
    }
}
