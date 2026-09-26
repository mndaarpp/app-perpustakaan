@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<h1>Tambah Kategori</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <p>
        <label>Nama Kategori</label><br>
        <input type="text" name="nama" value="{{ old('nama') }}">

        @error('nama')
        <span>{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label>Deskripsi</label><br>
        <textarea name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>

        @error('deskripsi')
        <span>{{ $message }}</span>
        @enderror
    </p>

    <button type="submit" class="btn">Simpan</button>

    <a href="{{ route('categories.index') }}" class="btn">
        Kembali
    </a>
</form>

@endsection