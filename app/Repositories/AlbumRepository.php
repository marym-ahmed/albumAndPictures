<?php

namespace App\Repositories;

use App\Models\Album;
use App\Models\Picture;
use Illuminate\Support\Facades\Storage;

class AlbumRepository
{
    public function createAlbum($data)
    {
        $album = Album::create([
            'name' => $data['name'],
            'image_path' => $data['image_path'] ?? null,
        ]);

        return $album;
    }

    public function addPicturesToAlbum($album, $pictures)
    {
        foreach ($pictures as $pictureData) {
            if (isset($pictureData['image']) && isset($pictureData['name'])) {
                $image = $pictureData['image'];
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $album->pictures()->create([
                    'name' => $pictureData['name'],
                    'image_path' => '/images/' . $imageName,
                ]);
            }
        }
    }

    public function updateAlbum($album, $data)
    {
        $album->update(['name' => $data['name']]);

        if (isset($data['existing_pictures'])) {
            foreach ($data['existing_pictures'] as $existingPictureData) {
                $picture = Picture::find($existingPictureData['id']);
                if ($picture) {
                    $picture->name = $existingPictureData['name'];

                    if (isset($existingPictureData['image'])) {
                        Storage::delete(public_path($picture->image_path));
                        $imageName = time() . '_' . $existingPictureData['image']->getClientOriginalName();
                        $existingPictureData['image']->move(public_path('images'), $imageName);
                        $picture->image_path = '/images/' . $imageName;
                    }

                    $picture->save();
                }
            }
        }

        if (isset($data['pictures'])) {
            $this->addPicturesToAlbum($album, $data['pictures']);
        }
    }

    public function deleteAlbum($album)
    {
        foreach ($album->pictures as $picture) {
            Storage::delete(public_path($picture->image_path));
            $picture->delete();
        }
        $album->delete();
    }

    public function movePicturesToAlbum($sourceAlbum, $targetAlbum)
    {
        foreach ($sourceAlbum->pictures as $picture) {
            $picture->album_id = $targetAlbum->id;
            $picture->save();
        }
    }
}
