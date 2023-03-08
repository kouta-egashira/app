@extends('layouts.app')
@section('content')

<div class="card mb-4">
    <div class="card-header">
            <span class="ml-auto">
                <a href="{{route('post.edit', $post)}}"><button class="btn btn-primary">編集</button></a>
            </span>
            <span class="ml-2">
                <form method="post" action="{{route('post.destroy', $post)}}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onClick="return confirm('本当に削除しますか？');">
                        削除
                    </button>
                </form>
            </span>
        </div>
        <div class="card-body">
            @if ($post->image)
                <div>
                    <img src="{{asset('storage/images/'.$post->image)}}" style="height: 230px;">
                </div>
            @endif
            <p class="card-text">
                {{$post->body}}
            </p>
        </div>
        <div class="detail">
            <p>書籍名：{{$post->title}}</p>
            <p>著者：{{$post->author}}</p>
            <p>出版社：{{$post->publication}}</p>
            <p>金額：{{$post->price}}円（税込み）</p>
        </div>

        <div class="card-footer">
            <span class="mr-2 float-right">
                投稿日時{{$post->created_at->diffForHumans()}}
            </span>
        </div>
    </div>
@endsection
