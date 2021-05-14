@extends('layouts.app')
@section('title','新規メモ作成｜MyNote')
@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class="card w-100">
        <div class="card-header">新規メモ作成</div>
        <div class="card-body">
            <form method='POST' action="{{ route('store') }}">
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                <div class="form-group">
                    <label for="title">タイトル</label>
                    @if($errors->has('title'))
                        <div class="text-danger">
                        {{ $errors->first('title') }}
                        </div>
                    @endif
                    <input type="text" name='title' class="form-control" id="title" value="{{ old('title') }}" placeholder="タイトルを入力">
                </div>
                <!-- メモ本文(content) -->
                <div class="form-group">
                    @if($errors->has('content'))
                        <div class="text-danger">
                        {{ $errors->first('content') }}
                        </div>
                    @endif
                     <textarea name='content' class="form-control"rows="10">{{ old('content') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="tag">タグ</label>
                    <input type="text" name='tag' class="form-control" id="tag" placeholder="タグを入力">
                </div>
                <button type='submit' class="btn btn-primary btn-lg w-25">保存</button>
            </form>
        </div>
    </div>
</div>
@endsection
