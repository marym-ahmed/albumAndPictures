@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Album Manager</h1>
    <a href="{{ route('albums.create') }}" class="btn btn-primary">Create Album</a>
    <div id="albums">
        @foreach($albums as $album)
            <div class="album" data-id="{{ $album->id }}">
                <div class="album-header">
                    <span class="album-name">{{ $album->name }}</span>
                    <div>
                        <a href="{{ route('albums.edit', $album->id) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('albums.destroy', $album->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="pictures">
                    @foreach($album->pictures as $picture)
                        <div class="picture" data-id="{{ $picture->id }}">
                            <img src="{{ asset($picture->image_path) }}" alt="{{ $picture->name }}" class="picture-image" style="max-width: 150px;"/>
                            <span class="picture-name">{{ $picture->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
