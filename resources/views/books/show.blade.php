@extends('layouts.app')

@section('content')
<div class="container" style="margin: 20px auto; max-width: 600px;">
    <h1>Detail Buku</h1>
    <p><a href="{{ route('books.index') }}">&larr; Kembali ke daftar buku</a></p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; width: 35%; text-align: left;">ID</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['id'] }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; text-align: left;">Judul</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['judul'] }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; text-align: left;">Penulis</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['penulis'] }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; text-align: left;">Penerbit</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['penerbit'] }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; text-align: left;">Tahun Terbit</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['tahun_terbit'] }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; text-align: left;">ISBN</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['isbn'] ?? '-' }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; text-align: left;">Stok</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['stok'] }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background-color: #f3f4f6; text-align: left;">ID Kategori</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $book['category_id'] }}</td>
        </tr>
    </table>

    <a href="{{ route('books.edit', $book['id']) }}" style="display: inline-block; margin-top: 16px; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">Edit Buku</a>
</div>
@endsection