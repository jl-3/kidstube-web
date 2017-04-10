@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <ol class="breadcrumb">
            <li><a href="{{ route('childHome') }}">Главная</a></li>
            <li><a href="{{ route('childVideoList', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
            <li class="active">Видео #{{ $video->id }}</li>
        </ol>

        <div class="row">
            <div class="col-sm-12">
                <iframe type="text/html" width="100%" height="640" frameborder="0" allowfullscreen
                        src="https://www.youtube.com/embed/{{ $video->code }}?autoplay=1&controls=0&playsinline=1&rel=0&showinfo=0&origin={{ config('app.url') }}"
                ></iframe>
            </div>
        </div>
    </div>
@endsection
