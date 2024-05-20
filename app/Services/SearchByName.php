<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Album;

use Illuminate\Support\Facades\Storage;
class SearchByName{

public function searchAlbumIdByName(Request $request)
    {
        $albumName = $request->query('name');
        $album = Album::where('name', $albumName)->first();

        if ($album) {
            return response()->json(['success' => true, 'album_id' => $album->id]);
        } else {
            return response()->json(['success' => false]);
        }
    }}
