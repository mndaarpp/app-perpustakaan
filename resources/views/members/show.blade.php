@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px; margin: 20px auto;">
    <h1>Detail Anggota</h1>

    <p>
        <a href="{{ route('members.index') }}">&larr; Kembali</a>
    </p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background: #f3f4f6; width: 30%; text-align: left;">ID</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->id }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background: #f3f4f6; text-align: left;">Nama</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->nama }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background: #f3f4f6; text-align: left;">NIM</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->nim }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background: #f3f4f6; text-align: left;">Email</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->email }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background: #f3f4f6; text-align: left;">Nomor Telepon</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->nomor_telepon }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background: #f3f4f6; text-align: left;">Alamat</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->alamat }}</td>
        </tr>
        <tr>
            <th style="border: 1px solid #ddd; padding: 8px 12px; background: #f3f4f6; text-align: left;">Status</th>
            <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->status }}</td>
        </tr>
    </table>

    <a href="{{ route('members.edit', $member->id) }}"
        style="display: inline-block; margin-top: 16px; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">
        Edit Anggota
    </a>

    <h2 style="margin-top: 30px;">Riwayat Peminjaman</h2>

    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        <thead>
            <tr style="background-color: #f3f4f6;">
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Kode Peminjaman</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Tanggal Pinjam</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Jatuh Tempo</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Tanggal Kembali</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($member->loans as $loan)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    {{ $loan->kode_peminjaman }}
                </td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    {{ $loan->tanggal_pinjam }}
                </td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    {{ $loan->tanggal_jatuh_tempo }}
                </td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    {{ $loan->tanggal_kembali ?? '-' }}
                </td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    {{ ucfirst($loan->status) }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                    Belum ada riwayat peminjaman.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection