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
                        <form action="{{ url('/video') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select class="form-control" name="category">
                                    <option value="">укажите категорию (не обязательно)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <form id="filter-form" action="{{ url('/videos') }}" method="get" class="pull-right">
                            <select id="filter-category" name="category">
                                <option value="">- все категории -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($filter == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                        Разрешённые видео
                    </div>

                    <div class="panel-body">
                        @forelse($videos as $video)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <iframe type="text/html" width="100%" height="240" frameborder="0"
                                                    src="http://www.youtube.com/embed/{{ $video->code }}?autoplay=0&origin=http://admin.kidstube.space/"
                                            ></iframe>
                                        </div>
                                        <div class="col-sm-6">
                                            <form class="form-inline" method="post"
                                                  action="{{ url('/video/'.$video->id.'/addTo') }}">
                                                {{ csrf_field() }}
                                                <table class="table table-hover">
                                                    @foreach($video->categories as $category)
                                                        <tr>
                                                            <td>{{ $category->name }}</td>
                                                            <td>
                                                                <a class="btn btn-sm btn-danger"
                                                                   href="{{ url('/video/'.$video->id.'/removeFrom/'.$category->id) }}"
                                                                >Убрать</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <select class="form-control input-sm" name="category">
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-sm btn-default">
                                                                Добавить
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <form class="form-inline" action="{{ url('/video/'.$video->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-xs btn-danger pull-right">Удалить</button>
                                        <span>{{ $video->created_at }}</span>
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
