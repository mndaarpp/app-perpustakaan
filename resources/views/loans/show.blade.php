@extends('layouts.app')

@section('content')

<div style="margin: 30px auto; max-width: 700px; padding: 0 15px; font-family: sans-serif;">

    <h1 style="font-size: 26px; font-weight: bold; margin-bottom: 12px; color: #111827;">
        Detail Peminjaman
    </h1>

    <p style="margin-bottom: 20px;">
        <a href="{{ route('loans.index') }}"
            style="color: #2563eb; text-decoration: none;">
            &larr; Kembali ke daftar peminjaman
        </a>
    </p>

    @if (session('success'))
    <div style="padding: 10px; background: #dcfce7; color: #166534; margin-bottom: 15px; border-radius: 4px;">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div style="padding: 10px; background: #fee2e2; color: #991b1b; margin-bottom: 15px; border-radius: 4px;">
        {{ session('error') }}
    </div>
    @endif

    {{-- Informasi Peminjaman --}}
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db; font-size: 14px; background: #ffffff;">

        <tr>
            <th style="width: 200px; background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Kode Peminjaman
            </th>
            <td style="border: 1px solid #d1d5db; padding: 10px 12px; font-family: monospace; font-weight: 600;">
                {{ $loan->kode_peminjaman }}
            </td>
        </tr>

        <tr>
            <th style="background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Anggota
            </th>
            <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                {{ $loan->member->nama ?? '-' }}
                ({{ $loan->member->nim ?? '-' }})
            </td>
        </tr>

        <tr>
            <th style="background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Petugas
            </th>
            <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                {{ $loan->user->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <th style="background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Tanggal Pinjam
            </th>
            <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                {{ $loan->tanggal_pinjam }}
            </td>
        </tr>

        <tr>
            <th style="background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Jatuh Tempo
            </th>
            <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                {{ $loan->tanggal_jatuh_tempo ?? '-' }}
            </td>
        </tr>

        <tr>
            <th style="background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Tanggal Dikembalikan
            </th>
            <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                {{ $loan->tanggal_kembali ?? '-' }}
            </td>
        </tr>

        <tr>
            <th style="background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Status
            </th>

            <td style="border: 1px solid #d1d5db; padding: 10px 12px;">

                @if ($loan->status === 'dikembalikan')

                <span style="color: #166534; background: #dcfce7; padding: 3px 8px; border-radius: 4px; font-size: 13px; font-weight: bold;">
                    Dikembalikan
                </span>

                @elseif ($loan->status === 'terlambat')

                <span style="color: #991b1b; background: #fee2e2; padding: 3px 8px; border-radius: 4px; font-size: 13px; font-weight: bold;">
                    Terlambat
                </span>

                @else

                <span style="color: #854d0e; background: #fef08a; padding: 3px 8px; border-radius: 4px; font-size: 13px; font-weight: bold;">
                    Dipinjam
                </span>

                @endif

            </td>
        </tr>

        <tr>
            <th style="background: #f9fafb; border: 1px solid #d1d5db; padding: 10px 12px; text-align: left;">
                Catatan
            </th>
            <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                {{ $loan->catatan ?? '-' }}
            </td>
        </tr>

    </table>

    {{-- Buku yang Dipinjam --}}
    <h2 style="font-size: 20px; font-weight: bold; margin-top: 30px; margin-bottom: 12px; color: #111827;">
        Buku yang Dipinjam
    </h2>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db; font-size: 14px; background: #ffffff;">

        <thead>
            <tr style="background: #f9fafb; text-align: left;">
                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">
                    Judul
                </th>

                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">
                    Penulis
                </th>

                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">
                    Jumlah
                </th>
            </tr>
        </thead>

        <tbody>

            @forelse ($loan->loanItems as $item)

            <tr>
                <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                    {{ $item->book->judul ?? '-' }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                    {{ $item->book->penulis ?? '-' }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px;">
                    {{ $item->jumlah }}
                </td>
            </tr>

            @empty

            <tr>
                <td colspan="3" style="border: 1px solid #d1d5db; padding: 12px; text-align: center; color: #6b7280;">
                    Tidak ada buku terkait.
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection