@extends('layouts.app')
@section('title','メモ編集｜MyNote')
@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class="card w-100">
        <div class="card-header d-flex justify-content-between">メモ編集
            <!-- 削除ボタン -->
            <form method="GET" action="{{ route('delete' , ['id' => $memo['id']] ) }}">
            @csrf
            <button class="p-0 mr-3" style="border: none;"><i class="fas fa-trash-alt"></i></button>
            </form>
        </div>
        <div class="card-body">
            <form method='POST' action="{{ route('update' , ['id' => $memo['id']] ) }}">
                @csrf
                <!-- メモ入力 -->
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                <div class="form-group">
                    <label for="title">タイトル</label>
                    @if($errors->has('title'))
                        <div class="text-danger">
                        {{ $errors->first('title') }}
                        </div>
                    @endif
                    <input type="text" name='title' class="form-control" id="title" value="{{ $memo['title'] }}">
                </div>
                <!-- メモ本文(content) -->
                <div class="form-group">
                    @if($errors->has('content'))
                        <div class="text-danger">
                        {{ $errors->first('content') }}
                        </div>
                    @endif
                     <textarea name='content' class="form-control" rows="10">{{ $memo['content'] }}</textarea>
                </div>
                <!-- タグ選択 -->
                <div class="form-group">
                    <label for="tag">タグ</label>
                    <select name="tag_id" id="tag" class="form-control">
                        @foreach($tags as $tag)
                            <option value="{{ $tag['id'] }}" {{ $tag['id'] == $memo['tag_id'] ? "selected" : "" }}>{{ $tag['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button type='submit' class="btn btn-primary btn-lg  w-25">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection
