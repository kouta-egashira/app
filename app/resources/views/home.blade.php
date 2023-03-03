@extends('layouts.app')
@section('content')

    @if (session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
    @endif

    <div class="home">
        <h3>home</h3>
        {{$user->name}}さんがログイン中です！
    </div>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('post.index') }}">
        <div class="search">
            <input type="search" placeholder="ユーザー名を入力" name="search" value="@if (isset($search)) {{ $search }} @endif">
        </div>
        <div class="btn">
           <button type="submit">検索</button>
           <button><a href="{{ route('post.index') }}" class="text-red">クリア</a></button>
        </div>
    </form>

    @foreach ($posts as $post)
        <div class="container-fluid mt-20" style="margin-left: 50px;">
            <div class="row">
                <div class="col-md-7">
                    <div class="card mb-5">
                        <div class="card-header">
                            <div class="media flex-wrap w-100 align-items-enter">
                                <div class="text-muted small mi-3">
                                    <a href="{{route('post.show', $post)}}">{{$post->title}}</a>
                                    <div class="text-muted small">{{$post->user->name}}</div>
                                </div>
                                <div class="text-muted small mi-3">
                                    <div>投稿日</div>
                                    <div><strong>{{$post->created_at->diffForHumans()}}</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>{{$post->body}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
