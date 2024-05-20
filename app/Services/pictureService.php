<?php

namespace App\Services;

use App\Http\Requests\DeleteOrMovePicturesRequest;
use App\Models\Album;
use App\Repositories\AlbumRepository;
use Illuminate\Support\Facades\Storage;

class PictureService
{
    protected $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    public function deleteOrMovePicture(DeleteOrMovePicturesRequest $request, $id)
    {
        $album = Album::findOrFail($id);

        if ($request->action == 'delete') {
            $this->deleteAlbumPictures($album);
            $this->albumRepository->deleteAlbum($album);
        } elseif ($request->action == 'move' && $request->filled('target_album_id')) {
            $targetAlbum = Album::findOrFail($request->target_album_id);
            $this->movePicturesToAlbum($album, $targetAlbum);
            $this->albumRepository->deleteAlbum($album);
        }
    }

    protected function deleteAlbumPictures(Album $album)
    {
        foreach ($album->pictures as $picture) {
            Storage::delete(public_path($picture->image_path));
            $picture->delete();
        }
    }

    protected function movePicturesToAlbum(Album $album, Album $targetAlbum)
    {
        foreach ($album->pictures as $picture) {
            $picture->album_id = $targetAlbum->id;
            $picture->save();
        }
    }
}
