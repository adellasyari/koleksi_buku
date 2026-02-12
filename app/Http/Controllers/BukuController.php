<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\Redirect;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Ambil semua buku beserta relasi kategori
        $bukus = Buku::with('kategori')->get();

        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'idkategori' => 'required|exists:kategoris,idkategori',
            'kode' => 'required|string|max:100',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
        ]);

        Buku::create($data);

        return Redirect::route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $data = $request->validate([
            'idkategori' => 'required|exists:kategoris,idkategori',
            'kode' => 'required|string|max:100',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
        ]);

        $buku->update($data);

        return Redirect::route('buku.index')->with('success', 'Buku berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return Redirect::route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
