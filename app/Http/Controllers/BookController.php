<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = [
            [
                'id' => 1,
                'judul' => 'Pemrograman Laravel',
                'penulis' => 'Andi',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2024,
                'stok' => 5,
                'kategori' => 'Pemrograman',
            ],
            [
                'id' => 2,
                'judul' => 'Basis Data',
                'penulis' => 'Budi',
                'penerbit' => 'Elex Media',
                'tahun_terbit' => 2023,
                'stok' => 3,
                'kategori' => 'Database',
            ],
        ];

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
            'kategori' => 'required',
        ]);

        return redirect()->route('books.index')
            ->with(
                'success',
                "Buku \"{$validated['judul']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database)."
            );
    }

    public function show(string $id)
    {
        return "BookController@show, id: {$id}";
    }

    public function edit(string $id)
    {
        return "BookController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "BookController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return "BookController@destroy, id: {$id}";
    }
}
