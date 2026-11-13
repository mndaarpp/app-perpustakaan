@extends('layouts.app')

@section('content')
<div style="margin: 30px auto; max-width: 1100px; padding: 0 15px; font-family: sans-serif;">

    <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 20px; color: #111827;">Daftar Peminjaman</h1>

    {{-- Error Flash Message (Notifikasi sukses otomatis dirender oleh layouts/app.blade.php) --}}
    @if (session('error'))
    <div style="padding: 10px 14px; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; margin-bottom: 16px; border-radius: 4px;">
        {{ session('error') }}
    </div>
    @endif

    {{-- Tombol Tambah --}}
    <div style="margin-bottom: 16px;">
        <a href="{{ route('loans.create') }}"
            style="display: inline-block; padding: 8px 16px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: 500;">
            + Tambah Peminjaman
        </a>
    </div>

    {{-- Tabel Peminjaman --}}
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db; font-size: 14px; background-color: #ffffff;">
        <thead>
            <tr style="background-color: #f9fafb; text-align: left;">
                <th style="border: 1px solid #d1d5db; padding: 10px 12px; width: 40px; text-align: center;">No</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">Kode Peminjaman</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">Anggota</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">Petugas</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">Buku</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px; text-align: center;">Tanggal Pinjam</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px; text-align: center;">Jatuh Tempo</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px; text-align: center;">Status</th>
                <th style="border: 1px solid #d1d5db; padding: 10px 12px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loans as $loan)
            <tr>
                <td style="border: 1px solid #d1d5db; padding: 10px 12px; text-align: center; vertical-align: middle;">
                    {{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; vertical-align: middle; word-break: break-word;">
                    {{ $loan->kode_peminjaman }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; vertical-align: middle;">
                    {{ $loan->member->nama ?? '-' }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; vertical-align: middle;">
                    {{ $loan->user->name ?? '-' }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; vertical-align: middle;">
                    @foreach ($loan->loanItems as $item)
                    {{ $item->book->judul ?? '-' }}@if (!$loop->last), @endif
                    @endforeach
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; text-align: center; vertical-align: middle; white-space: nowrap;">
                    {{ $loan->tanggal_pinjam }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; text-align: center; vertical-align: middle; white-space: nowrap;">
                    {{ $loan->tanggal_jatuh_tempo ?? $loan->tanggal_kembali }}
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; text-align: center; vertical-align: middle;">
                    @if ($loan->status === 'dikembalikan')
                    <span style="color: #166534; background: #dcfce7; padding: 3px 8px; border-radius: 4px; font-size: 13px;">
                        Dikembalikan
                    </span>
                    @elseif ($loan->status === 'terlambat')
                    <span style="color: #991b1b; background: #fee2e2; padding: 3px 8px; border-radius: 4px; font-size: 13px;">
                        Terlambat
                    </span>
                    @else
                    <span style="color: #854d0e; background: #fef08a; padding: 3px 8px; border-radius: 4px; font-size: 13px;">
                        Dipinjam
                    </span>
                    @endif
                </td>

                <td style="border: 1px solid #d1d5db; padding: 10px 12px; white-space: nowrap; vertical-align: middle;">
                    <a href="{{ route('loans.show', $loan->id) }}" style="color: #2563eb; text-decoration: underline;">Detail</a>
                    <span style="color: #6b7280; margin: 0 4px;">|</span>
                    <a href="{{ route('loans.edit', $loan->id) }}" style="color: #2563eb; text-decoration: underline;">Edit</a>

                    @if ($loan->status !== 'dikembalikan')
                    <span style="color: #6b7280; margin: 0 4px;">|</span>
                    <form action="{{ route('loans.kembalikan', $loan->id) }}" method="POST" style="display: inline; margin: 0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            style="background-color: #16a34a; color: #ffffff; border: none; padding: 4px 8px; border-radius: 4px; font-size: 13px; cursor: pointer;"
                            onclick="return confirm('Konfirmasi pengembalian buku?')">
                            Kembalikan
                        </button>
                    </form>
                    @endif

                    @if ($loan->status === 'dikembalikan')
                    <span style="color: #6b7280; margin: 0 4px;">|</span>
                    <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display: inline; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="background-color: #dc2626; color: #ffffff; border: none; padding: 4px 8px; border-radius: 4px; font-size: 13px; cursor: pointer;"
                            onclick="return confirm('Yakin ingin menghapus transaksi peminjaman ini?')">
                            Hapus
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="border: 1px solid #d1d5db; padding: 16px; text-align: center; color: #6b7280;">
                    Belum ada data peminjaman.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div style="margin-top: 16px;">
        {{ $loans->links() }}
    </div>

</div>
@endsection