@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            @forelse($videos as $video)
                <div class="col-sm-3">
                    <a class="thumbnail" href="{{ url('/play/'.$video->id) }}">
                        <img src="http://img.youtube.com/vi/{{ $video->code }}/0.jpg" width="100%" height="240">
                    </a>
                </div>
            @empty
                <div class="alert alert-success">
                    Пока что нет ни одного разрешённого видео.
                </div>
            @endforelse
        </div>

        <div class="panel-footer panel-footer-pagination">
            {{ $videos->appends(['category' => $filter])->links() }}
        </div>
    </div>
@endsection
