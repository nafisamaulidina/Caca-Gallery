@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="my-4 text-center">Create Photo</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <input type="hidden" name="album_id" value="{{ $album_id }}">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
