@extends('layouts.app')

@section('content')
<div class="container" style="margin: 20px auto; max-width: 1000px;">
    <h1>Daftar Buku</h1>

    <p><a href="{{ route('books.create') }}" style="display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">+ Tambah Buku</a></p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        <thead>
            <tr style="background-color: #f3f4f6;">
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">ID</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Judul</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Penulis</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Penerbit</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Tahun</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Stok</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">ID Kategori</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book->id }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book->judul }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book->penulis }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book->penerbit }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book->tahun_terbit }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book->stok }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book->category_id }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    <a href="{{ route('books.show', $book->id) }}">Detail</a> |
                    <a href="{{ route('books.edit', $book->id) }}">Edit</a> |
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc2626; color: #fff; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="border: 1px solid #ddd; padding: 12px; text-align: center;">Belum ada data buku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $books->links() }}
    </div>
</div>
@endsection