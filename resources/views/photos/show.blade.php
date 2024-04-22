@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    <h1>{{$photo->judul}}</h1>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $photo->deskripsi }}</p>
                    <a href="/albums/{{$photo->album->id}}" class="btn btn-secondary">Back</a>
                    <form action="{{route('photos.destroy' , $photo->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger ml-2">Hapus</button>
                    </form>
                    @if($existingLike)
                    <form id="like-form-{{$photo->id}}" method="POST" action="{{ route('likes.toggle', $photo->id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm card-text float-end text-danger shadow fs-5">❤<span>{{$likes->count()}}</span></button>
                    </form>
                @else
                    <form id="like-form-{{$photo->id}}" method="POST" action="{{ route('likes.toggle', $photo->id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm card-text float-end">❤<span>{{$likes->count()}}</span></button>
                    </form>
                @endif
                </div>
                <div class="card-footer">
                    <img src="/storage/albums/{{$photo->album->id}}/{{$photo->foto}}" alt="" class="img-fluid mx-auto d-block">
                </div>
            </div>

            <!-- Form Komentar -->
            <div class="card mt-3">
                <div class="card-header">
                    Add a Comment
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.store', $photo->id) }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="isikomentar" rows="3" class="form-control" placeholder="Add a comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Comment</button>
                    </form>
                </div>
            </div>

            <!-- Daftar Komentar -->
            <div class="card mt-3">
                <div class="card-header">
                    Comments
                </div>
                <div class="card-body">
                    @foreach ($photo->photoComments as $comment)
                        <p>{{ $comment->user->username }}: {{ $comment->isikomentar }}</p>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Check if the user has liked the current photo
    $.ajax({
        url: "{{ route('likes.check', $photo->id) }}",
        type: "GET",
        success: function(response) {
            if (response.liked) {
                // If already liked, hide the Like button
                $('#like-form-{{$photo->id}}').hide();
            }
        }
    });

    // Event handler for Like form
    $('#like-form-{{$photo->id}}').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var form = $(this);
        var url = form.attr('action');

        // Send AJAX request
        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Show message from response
                alert(response.message);

                // Update button display
                form.hide();
                form.siblings('.unlike-form').show();
            },
            error: function(xhr) {
                // Handle errors
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });

    // Event handler for Unlike form
    $('#unlike-form-{{$photo->id}}').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var form = $(this);
        var url = form.attr('action');

        // Send AJAX request
        $.ajax({
            url: url,
            type: 'DELETE',
            data: form.serialize(),
            success: function(response) {
                // Show message from response
                alert(response.message);

                // Update button display
                form.hide();
                form.siblings('.like-form').show();
            },
            error: function(xhr) {
                // Handle errors
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});

</script>
@endsection
