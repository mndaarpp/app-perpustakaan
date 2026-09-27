@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 20px auto;">
    <h1>Edit Buku</h1>
    <p><a href="{{ route('books.index') }}">&larr; Kembali ke daftar buku</a></p>

    <form action="{{ route('books.update', $book['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 12px;">
            <label for="judul" style="display:block; font-weight:bold;">Judul</label>
            <input type="text" name="judul" id="judul" value="{{ old('judul', $book['judul']) }}" style="width:100%; padding:8px;">
            @error('judul')
            <div style="color:red; font-size:14px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="penulis" style="display:block; font-weight:bold;">Penulis</label>
            <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $book['penulis']) }}" style="width:100%; padding:8px;">
            @error('penulis')
            <div style="color:red; font-size:14px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="penerbit" style="display:block; font-weight:bold;">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $book['penerbit']) }}" style="width:100%; padding:8px;">
            @error('penerbit')
            <div style="color:red; font-size:14px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="tahun_terbit" style="display:block; font-weight:bold;">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $book['tahun_terbit']) }}" style="width:100%; padding:8px;">
            @error('tahun_terbit')
            <div style="color:red; font-size:14px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="isbn" style="display:block; font-weight:bold;">ISBN (opsional)</label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book['isbn']) }}" style="width:100%; padding:8px;">
            @error('isbn')
            <div style="color:red; font-size:14px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="stok" style="display:block; font-weight:bold;">Stok</label>
            <input type="number" name="stok" id="stok" value="{{ old('stok', $book['stok']) }}" style="width:100%; padding:8px;">
            @error('stok')
            <div style="color:red; font-size:14px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="category_id" style="display:block; font-weight:bold;">Kategori</label>
            <select name="category_id" id="category_id" style="width:100%; padding:8px;">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $book['category_id']) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nama_kategori }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <div style="color:red; font-size:14px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="padding: 8px 16px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Perbarui</button>
    </form>
</div>
@endsection