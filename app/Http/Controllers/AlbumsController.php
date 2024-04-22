<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $albums = Album::where('user_id', $userId)->paginate(6);

        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'NamaAlbum' => 'required',
            'Deskripsi' => 'required',
        ]);

        Album::create([
            'NamaAlbum' => $request->input('NamaAlbum'),
            'Deskripsi' => $request->input('Deskripsi'),
            'user_id' => auth()->id(),
        ]);

        return redirect('/albums')->with('success', 'Album created');
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);

        if ($album->user_id !== auth()->id()) {
            return back()->with('danger', 'You are not authorized to delete this album');
        }

        $album->delete();

        return redirect('/albums')->with('success', 'Album deleted');
    }
    public function allAlbum()
    {
        $albums = Album::all();
        return view('albums.all', compact('albums'));
    }
}
