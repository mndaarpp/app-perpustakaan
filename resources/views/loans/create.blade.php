@extends('layouts.app')

@section('content')
<div class="container" style="margin: 20px auto; max-width: 1000px;">

    <h1>Tambah Peminjaman</h1>

    {{-- Informasi Petugas Otomatis dari Session Login --}}
    <p style="background: #f8fafc; padding: 10px; border-left: 4px solid #2563eb; margin-bottom: 16px;">
        <em>Petugas pencatat: <strong>{{ auth()->user()->name }}</strong> (otomatis dari akun yang login).</em>
    </p>

    @if ($errors->any())
    <div style="padding: 10px; background: #fee2e2; color: #991b1b; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('loans.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Anggota</label><br>

            <select name="member_id" required
                style="width: 100%; padding: 8px;">
                <option value="">-- Pilih Anggota --</option>

                @foreach ($members as $member)
                <option value="{{ $member->id }}"
                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                    {{ $member->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Tanggal Pinjam</label><br>
            <input type="date" name="tanggal_pinjam"
                value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Tanggal Jatuh Tempo</label><br>
            <input type="date" name="tanggal_jatuh_tempo"
                value="{{ old('tanggal_jatuh_tempo') }}"
                required style="width: 100%; padding: 8px;">
        </div>

        <h3>Daftar Buku</h3>

        <div style="margin-bottom: 15px;">
            <label>Buku</label><br>

            <select name="books[0][book_id]" required
                style="width: 100%; padding: 8px;">
                <option value="">-- Pilih Buku --</option>

                @foreach ($books as $book)
                <option value="{{ $book->id }}">
                    {{ $book->judul }} (Stok: {{ $book->stok }})
                </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Jumlah Buku</label><br>
            <input type="number" name="books[0][jumlah]"
                min="1" value="1" required
                style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Catatan</label><br>
            <textarea name="catatan"
                style="width: 100%; padding: 8px;"
                rows="3">{{ old('catatan') }}</textarea>
        </div>

        <button type="submit"
            style="background: #2563eb; color: white; padding: 10px 16px; border: none; border-radius: 4px; cursor: pointer;">
            Simpan Peminjaman
        </button>

        <a href="{{ route('loans.index') }}"
            style="margin-left: 10px;">
            Kembali
        </a>

    </form>
</div>
@endsection