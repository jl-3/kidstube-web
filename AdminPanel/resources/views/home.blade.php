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

                <div class="panel panel-default">
                    <div class="panel-heading">Новое видео</div>

                    <div class="panel-body">
                        <form action="{{ url('/video') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input class="form-control" placeholder="URL видео" name="url" required>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Добавить</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Разрешённые видео</div>

                    <div class="panel-body">
                        @foreach($videos as $video)
                            <iframe type="text/html" width="320" height="240" frameborder="0"
                                    src="http://www.youtube.com/embed/{{ $video->code }}?autoplay=0&origin=http://admin.kidstube.space/"
                            ></iframe>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
