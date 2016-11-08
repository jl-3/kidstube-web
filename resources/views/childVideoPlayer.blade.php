@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-sm-12">
                <iframe type="text/html" width="100%" height="640" frameborder="0" allowfullscreen
                        src="http://www.youtube.com/embed/{{ $video->code }}?autoplay=1&controls=0&playsinline=1&rel=0&showinfo=0&origin=http://admin.kidstube.space/"
                ></iframe>
            </div>
        </div>
    </div>
@endsection
