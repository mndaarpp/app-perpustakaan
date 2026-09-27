@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="container" style="margin: 20px auto; max-width: 1000px;">
    <h1>Daftar Kategori</h1>

    @if (session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 4px; margin-bottom: 16px;">
        {{ session('success') }}
    </div>
    @endif

    <p>
        <a href="{{ route('categories.create') }}" class="btn" style="display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">
            + Tambah Kategori
        </a>
    </p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        <thead>
            <tr style="background-color: #f3f4f6;">
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">ID</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Nama Kategori</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Deskripsi</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $category->id }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $category->nama_kategori }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $category->deskripsi ?? '-' }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    <a href="{{ route('categories.edit', $category->id) }}">Edit</a>
                    |
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc2626; color: #fff; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="border: 1px solid #ddd; padding: 12px; text-align: center;">Belum ada data kategori.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $categories->links() }}
    </div>
</div>
@endsection