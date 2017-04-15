@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <div class="panel panel-info">
                    <div class="panel-heading">Новое видео</div>

                    <div class="panel-body">
                        <form action="{{ route('videos.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select class="form-control" name="category" required>
                                    <option value="">- укажите категорию -</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id == $filter) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group">
                                <input class="form-control" placeholder="URL видео" name="url" required>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Добавить</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="alert alert-danger">
                    Скачанные локально {{ $local_count }} видео в совокупности весят на данный момент {{ $local_size }}.
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <form id="filter-form" action="{{ route('videos.index') }}" method="get" class="pull-right">
                            <select id="filter-category" name="category">
                                <option value="">- все категории -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == $filter) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        Разрешённые видео
                    </div>

                    <div class="panel-body">
                        @forelse ($videos as $video)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="https://www.youtube.com/watch?v={{ $video->code }}" target="_blank">
                                                <img src="https://img.youtube.com/vi/{{ $video->code }}/0.jpg" width="100%" height="240">
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <form class="form-inline" method="post" action="{{ route('videos.update', ['video' => $video->id]) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}

                                                <div class="input-group">
                                                    <select class="form-control" name="category_id" required>
                                                        <option value="">- укажите категорию -</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" @if ($category->id == $video->category_id) selected @endif>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-btn">
                                                        <button type="submit" class="btn btn-default" title="Изменить категорию">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <form class="form-inline" action="{{ route('videos.destroy', ['video' => $video->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-xs btn-danger pull-right">Удалить</button>
                                        <span>{{ $video->updated_at }}</span>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-success">
                                У вас пока нет ни одного разрешённого видео.
                                Добавляйте их через форму, расположенную выше на данной странице!
                            </div>
                        @endforelse
                    </div>

                    <div class="panel-footer panel-footer-pagination">
                        {{ $videos->appends(['category' => $filter])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
