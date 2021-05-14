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
    public function myMemo($user_id)
    {
        $tag = Request('tag'); //URLに「tag」があるか確認
        // dd($tag);

        if (empty($tag)) {
            // タグ「tag」がなければ、その人が持っているメモを全て取得
            return $this::select('memos.*')->where('user_id', $user_id)->where('deleted_at',null)->get();
        } else {
            // タグ「tag」の指定があればタグで絞る ->wher(tagがクエリパラメーターで取得したものに一致)
            $memos = $this::select('memos.*')
                ->leftJoin('tags', 'tags.id', '=', 'memos.tag_id')
                ->where('tags.name', $tag)
                ->where('tags.user_id', $user_id)
                ->where('memos.user_id', $user_id)
                ->where('memos.deleted_at',null)
                ->get();
            return $memos;
        }
    }

    // メモ編集画面のメモ一覧表示（tag_idの絞り込みのアリorナシの分岐）
    public function selectMemo($user_id,$id)
    {
        $tag_id = $this::select('memos.tag_id')->where('id',$id)->where('user_id',$user_id)->where('deleted_at',null)->first();
        // dd($tag_id['tag_id']);

        if (empty($tag_id['tag_id'])) {
            // 「tag_id」がなければ、その人が持っているメモを全て取得
            return $this::select('memos.*')->where('user_id', $user_id)->where('deleted_at',null)->get();
            
        } else {
            // 「tag_id」の指定があればtag_idで絞る ->where(tagがクエリパラメーターで取得したものに一致)
            $memos = $this::select('memos.*')->where('user_id', $user_id)->where('deleted_at',null)->where('tag_id',$tag_id['tag_id'])->get();
            return $memos;
        }
    }
}
