@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Album</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Album Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $album->name }}" required>
        </div>

        <div id="existing-pictures-container">
            <h3>Existing Pictures</h3>
            @foreach ($album->pictures as $index => $picture)
                <div class="form-group">
                    <label for="existing_pictures_{{ $index }}_name">Picture Name</label>
                    <input type="text" name="existing_pictures[{{ $index }}][name]" class="form-control" id="existing_pictures_{{ $index }}_name" value="{{ $picture->name }}" required>
                    <label for="existing_pictures_{{ $index }}_image">Change Picture</label>
                    <input type="file" name="existing_pictures[{{ $index }}][image]" class="form-control">
                    <input type="hidden" name="existing_pictures[{{ $index }}][id]" value="{{ $picture->id }}">
                    <img src="{{ asset($picture->image_path) }}" alt="{{ $picture->name }}" width="100">
                </div>
            @endforeach
        </div>

        <div id="pictures-container">
            <h3>Add New Pictures</h3>
            <div class="form-group">
                <label for="pictures">Picture</label>
                <input type="file" name="pictures[0][image]" class="form-control">
                <input type="text" name="pictures[0][name]" class="form-control" placeholder="Picture Name">
            </div>
        </div>

        <button type="button" id="add-picture" class="btn btn-secondary">Add Another Picture</button>
        <button type="submit" class="btn btn-primary">Update Album</button>
    </form>
</div>

<script>
    let pictureIndex = 1;
    document.getElementById('add-picture').addEventListener('click', function() {
        const container = document.getElementById('pictures-container');
        const newPicture = document.createElement('div');
        newPicture.className = 'form-group';
        newPicture.innerHTML = `
            <label for="pictures">Picture</label>
            <input type="file" name="pictures[${pictureIndex}][image]" class="form-control">
            <input type="text" name="pictures[${pictureIndex}][name]" class="form-control" placeholder="Picture Name">
        `;
        container.appendChild(newPicture);
        pictureIndex++;
    });
</script>
@endsection
