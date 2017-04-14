@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <ol class="breadcrumb">
            <li class="active">Главная</li>
        </ol>

        <div class="row">
            @forelse($categories as $category)
                <div class="col-sm-3">
                    <a class="thumbnail" href="{{ route('kid-category', ['category' => $category->id]) }}">
                        <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}">
                        <div class="caption">{{ $category->name }}</div>
                    </a>
                </div>
            @empty
            @endforelse
        </div>
    </div>
@endsection
