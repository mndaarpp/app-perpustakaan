@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 20px auto;">
    <h1>Edit Kategori</h1>
    <p><a href="{{ route('categories.index') }}">&larr; Kembali ke daftar kategori</a></p>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 12px;">
            <label for="nama_kategori" style="display:block; font-weight:bold;">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" style="width:100%; padding:8px;">
            @error('nama_kategori')
            <div style="color:red; font-size:14px; margin-top:4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="deskripsi" style="display:block; font-weight:bold;">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" style="width:100%; padding:8px;">{{ old('deskripsi', $category->deskripsi) }}</textarea>
            @error('deskripsi')
            <div style="color:red; font-size:14px; margin-top:4px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="padding: 8px 16px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Perbarui</button>
    </form>
</div>
@endsection