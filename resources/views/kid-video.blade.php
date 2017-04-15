@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <ol class="breadcrumb">
            <li><a href="{{ route('kid-home') }}">Главная</a></li>
            <li><a href="{{ route('kid-category', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
            <li class="active">Видео #{{ $video->id }}</li>
        </ol>

        <div class="row">
            <div class="col-sm-12">
                <youtube code="{{ $video->code }}" origin="{{ config('app.url') }}"></youtube>
            </div>
        </div>
    </div>
@endsection
