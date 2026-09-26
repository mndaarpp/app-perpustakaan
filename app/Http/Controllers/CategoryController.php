<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = [
            [
                'id' => 1,
                'nama' => 'Pemrograman',
                'deskripsi' => 'Buku tentang pemrograman dan pengembangan aplikasi.',
            ],
            [
                'id' => 2,
                'nama' => 'Database',
                'deskripsi' => 'Buku tentang basis data dan pengelolaan data.',
            ],
            [
                'id' => 3,
                'nama' => 'Jaringan',
                'deskripsi' => 'Buku tentang jaringan komputer dan komunikasi data.',
            ],
        ];

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        return redirect()->route('categories.index')
            ->with(
                'success',
                "Kategori \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database)."
            );
    }

    public function edit(string $id)
    {
        return "CategoryController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "CategoryController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return "CategoryController@destroy, id: {$id}";
    }
}
