<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Repositories\AlbumRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Http\Requests\DeleteOrMovePicturesRequest;
use App\Services\SearchByName;
use App\Services\PictureService;
class AlbumController extends Controller
{
    protected $albumRepository;
    protected $searchByName;
    protected $pictureService;

    public function __construct(AlbumRepository $albumRepository,SearchByName $searchByName,pictureService $pictureService)
    {
        $this->albumRepository = $albumRepository;
        $this->searchByName =$searchByName;
        $this->pictureService =$pictureService;
    }

    public function index()
    {
        $albums = Album::all();
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(StoreAlbumRequest $request)
    {

        $album = $this->albumRepository->createAlbum($request->only('name'));

        if ($request->has('pictures')) {
            $this->albumRepository->addPicturesToAlbum($album, $request->pictures);
        }

        return redirect()->route('albums.index');
    }

    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    public function update(UpdateAlbumRequest $request, Album $album)
    {


        $this->albumRepository->updateAlbum($album, $request->all());

        return redirect()->route('albums.index');
    }

    public function destroy(Album $album)
    {
        if ($album->pictures()->count() > 0) {
            return view('albums.deleteOrMovePictures', compact('album'));
        }

        $this->albumRepository->deleteAlbum($album);

        return redirect()->route('albums.index');
    }

    public function getAlbumIdByName(Request $request)
    {
        $response =$this->searchByName->searchAlbumIdByName($request);
        return $response;
    }

    public function deleteOrMovePictures(DeleteOrMovePicturesRequest $request, $id)
    {

        $this->pictureService->deleteOrMovePicture($request, $id);


        return redirect()->route('albums.index')->with('status', 'Action completed successfully.');
    }
}
