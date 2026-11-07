@extends('layouts.app')

@section('content')

<div style="margin: 30px auto; max-width: 800px; padding: 0 15px;">

    <h1 style="font-size: 26px; margin-bottom: 20px;">
        Edit Peminjaman
    </h1>

    @if ($errors->any())
    <div style="padding: 10px; background: #fee2e2; color: #991b1b; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('loans.update', $loan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label>Anggota</label>

            <select name="member_id" required
                style="width: 100%; padding: 9px; margin-top: 5px;">

                @foreach ($members as $member)
                <option value="{{ $member->id }}"
                    {{ old('member_id', $loan->member_id) == $member->id ? 'selected' : '' }}>
                    {{ $member->nama }}
                </option>
                @endforeach

            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Tanggal Pinjam</label>

            <input type="date"
                name="tanggal_pinjam"
                value="{{ old('tanggal_pinjam', $loan->tanggal_pinjam) }}"
                required
                style="width: 100%; padding: 9px; margin-top: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Tanggal Jatuh Tempo</label>

            <input type="date"
                name="tanggal_jatuh_tempo"
                value="{{ old('tanggal_jatuh_tempo', $loan->tanggal_jatuh_tempo) }}"
                required
                style="width: 100%; padding: 9px; margin-top: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Catatan</label>

            <textarea name="catatan"
                rows="4"
                style="width: 100%; padding: 9px; margin-top: 5px;">{{ old('catatan', $loan->catatan) }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label>Status Peminjaman</label>

            <input type="text"
                value="{{ ucfirst($loan->status) }}"
                disabled
                style="width: 100%; padding: 9px; margin-top: 5px; background: #f3f4f6;">
        </div>

        <button type="submit"
            style="background: #2563eb; color: white; padding: 10px 18px; border: none; border-radius: 4px; cursor: pointer;">
            Simpan Perubahan
        </button>

        <a href="{{ route('loans.index') }}"
            style="margin-left: 10px; color: #2563eb; text-decoration: none;">
            Kembali
        </a>

    </form>

</div>

@endsection