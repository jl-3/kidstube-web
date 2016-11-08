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
                    <div class="panel-heading">Новая категория</div>

                    <div class="panel-body">
                        <form action="{{ url('/category') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input class="form-control" placeholder="Название" name="name" required>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">Добавить</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">Имеющиеся категории</div>

                    <div class="panel-body">
                        @forelse($categories as $category)
                            <div class="row">
                                <div class="col-xs-9 col-sm-10">
                                    <form action="{{ url('/category/'.$category->id) }}" method="post">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <div class="panel panel-default">
                                            <div class="input-group">
                                                <input class="form-control" name="name" placeholder="Название"
                                                       value="{{ $category->name }}">
                                                <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default">
                                                <span class="glyphicon glyphicon-pencil hidden-md hidden-lg"></span>
                                                <span class="visible-md-inline-block visible-lg-inline-block">Изменить</span>
                                            </button>
                                        </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-xs-3 col-sm-2">
                                    <form action="{{ url('/category/'.$category->id) }}" method="post">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-trash hidden-md hidden-lg"></span>
                                            <span class="visible-md-inline-block visible-lg-inline-block">Удалить</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-success">
                                У вас пока нет ни одной категории.
                                Добавляйте их через форму, расположенную выше на данной странице!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
