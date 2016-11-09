@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <ol class="breadcrumb">
            <li><a href="{{ route('childHome') }}">Главная</a></li>
            <li class="active">{{ $category->name }}</li>
        </ol>

        <div class="row">
            @forelse($videos as $video)
                <div class="col-sm-3">
                    <a class="thumbnail" href="{{ route('childVideoPlayer', ['category' => $category->id, 'video' => $video->id]) }}">
                        <img src="http://img.youtube.com/vi/{{ $video->code }}/0.jpg" width="100%" height="240">
                    </a>
                </div>
            @empty
                <div class="alert alert-success">
                    В этой категории нет ни одного разрешённого видео.
                </div>
            @endforelse
        </div>

        <div class="panel-footer panel-footer-pagination">
            {{ $videos->links() }}
        </div>
    </div>
@endsection
