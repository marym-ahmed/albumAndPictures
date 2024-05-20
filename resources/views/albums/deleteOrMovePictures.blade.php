@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Delete or Move Pictures</h1>

    <form action="{{ route('albums.deleteOrMovePictures', $album->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="action">Choose an action</label>
            <select name="action" class="form-control" id="action" required>
                <option value="delete">Delete All Pictures</option>
                <option value="move">Move Pictures to Another Album</option>
            </select>
        </div>
        <div class="form-group" id="target-album-group" style="display: none;">
            <label for="target_album_name">Target Album Name</label>
            <input type="text" name="target_album_name" class="form-control" id="target_album_name">
            <input type="hidden" name="target_album_id" id="target_album_id">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    document.getElementById('action').addEventListener('change', function() {
        if (this.value === 'move') {
            document.getElementById('target-album-group').style.display = 'block';
        } else {
            document.getElementById('target-album-group').style.display = 'none';
        }
    });

    document.getElementById('target_album_name').addEventListener('change', function() {
        fetch('/albums/getAlbumIdByName?name=' + this.value)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('target_album_id').value = data.album_id;
                } else {
                    document.getElementById('target_album_id').value = '';
                    alert('Album not found');
                }
            });
    });
</script>
@endsection
