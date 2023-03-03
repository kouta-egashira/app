<div class="list-group">
    <a href="{{route('home')}}"
        class="{{url()->current()==route('home')? 'list-group-item active': 'list-group-item'}}"><!-- 三項演算子：現在のURLがもしrouteであればlist-group-item activeに、そうでなければlist-group-itemにする-->
        <i class="fas fa-home pr-2"></i><span>書籍一覧</span>
    </a>
    <a href="{{route('post.create')}}"
        class="{{url()->current()==route('post.create')? 'list-group-item active': 'list-group-item'}}">
        <i class="fas fa-pen-nib pr-2"></i><span>書籍追加</span>
    </a>
</div>
