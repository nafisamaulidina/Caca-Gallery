<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function create(int $album_id)
    {
        // Temukan album berdasarkan ID
        $album = Album::findOrFail($album_id);

        // Periksa apakah pengguna saat ini adalah pemilik album
        if ($album->user_id !== auth()->id()) {
            return redirect('/albums')->with('danger', 'You are not authorized to add photos to this album');
        }

        return view('photos.create', compact('album_id'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'foto' => 'required|image|max:1999',
            'deskripsi' => 'required',
            'album_id' => 'required|exists:albums,id'
        ]);

        $album = Album::findOrFail($request->input('album_id'));

        // Periksa apakah pengguna saat ini adalah pemilik album
        if ($album->user_id !== auth()->id()) {
            return redirect('/albums')->with('danger', 'You are not authorized to add photos to this album');
        }



        // Get filename with extension
        $filenameWithExt = $request->file('foto')->getClientOriginalName();

        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Get just extension
        $extension = $request->file('foto')->getClientOriginalExtension();

        // Filename to store
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                // Upload foto
                $path = $request->file('foto')->storeAs('public/albums/'. $request->input('album_id') ,$fileNameToStore);

        // Create photo
        $photo = new Photo;
        $photo->judul = $request->input('judul');
        $photo->deskripsi = $request->input('deskripsi');
        $photo->album_id = $request->input('album_id');
        $photo->foto = $fileNameToStore;
        $photo->user_id = auth()->id(); // Assign the current user's ID
        $photo->save();

        return redirect('/albums/' . $request->input('album_id'))->with('success', 'Photo created');
    }

    public function show(Photo $photo)
    {
        // Menampilkan detail foto
        $user = Auth::user();
        $existingLike = Like::where('user_id', $user->id)
        ->where('photo_id', $photo->id)
        ->first();
        $likes = Like::where('photo_id', $photo->id)->get(); // Mengambil semua data Like berdasarkan photo_id
        return view('photos.show', compact('photo','existingLike','likes'));
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        $album = $photo->album;

        // Periksa apakah pengguna saat ini adalah pemilik album atau foto
        if ($album->user_id !== auth()->id() && $photo->user_id !== auth()->id()) {
            return redirect('/albums/' . $album->id)->with('danger', 'You are not authorized to delete this photo');
        }

        // Hapus foto dari storage
        Storage::delete('public/photos/' . $photo->foto);

        // Hapus record foto dari database
        $photo->delete();

        return redirect('/albums/' . $photo->album_id)->with('success', 'Photo deleted');
    }
}

