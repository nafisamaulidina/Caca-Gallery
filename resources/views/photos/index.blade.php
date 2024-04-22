@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">All Photos</h1>
        <div class="row">
            @foreach ($photos as $photo)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="/storage/photos/{{ $photo->foto }}" class="card-img-top" alt="Photo">
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo->judul }}</h5>
                            <p class="card-text">{{ $photo->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
