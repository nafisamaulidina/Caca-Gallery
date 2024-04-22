@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Albums</h1>
        <div class="row">
            @foreach ($albums as $album)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $album->NamaAlbum }}</h5>
                            <p class="card-text">{{ $album->Deskripsi }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <form method="POST" action="{{ route('albums.destroy', $album->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                                <a href="{{ route('albums.show', $album->id) }}" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
