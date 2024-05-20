<!-- resources/views/albums/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create Album</h1>
    <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Album Name:</label>
            <input type="text" name="name" id="name" placeholder="Album Name" required>
        </div>
        <div id="pictures-container">
            <div class="picture-input">
                <label for="pictures">Upload Pictures:</label>
                <input type="file" name="pictures[0][image]" >
                <input type="text" name="pictures[0][name]" placeholder="Picture Name"  >
            </div>
        </div>
        <button type="button" id="addPicture">Add Another Picture</button>
        <br>
        <button type="submit">Create Album</button>
    </form>

    <script>
        let pictureIndex = 1;

        document.getElementById('addPicture').addEventListener('click', function () {
            const container = document.getElementById('pictures-container');

            const pictureDiv = document.createElement('div');
            pictureDiv.className = 'picture-input';

            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = `pictures[${pictureIndex}][image]`;
            fileInput.required = true;

            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.name = `pictures[${pictureIndex}][name]`;
            textInput.placeholder = 'Picture Name';
            textInput.required = true;

            pictureDiv.appendChild(fileInput);
            pictureDiv.appendChild(textInput);

            container.appendChild(pictureDiv);

            pictureIndex++;
        });
    </script>
@endsection
