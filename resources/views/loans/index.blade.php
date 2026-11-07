@extends('layouts.app')

@section('content')
<div class="container" style="margin: 20px auto; max-width: 1100px;">

    <h1>Daftar Peminjaman</h1>

    {{-- Notifikasi --}}
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

    {{-- Tombol tambah --}}
    <p>
        <a href="{{ route('loans.create') }}"
            style="display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">
            + Tambah Peminjaman
        </a>
    </p>

    {{-- Tabel peminjaman --}}
    <table style="width: 100%; border-collapse: collapse; margin-top: 16px;">

        <thead>
            <tr style="background-color: #f3f4f6;">
                <th style="border: 1px solid #ddd; padding: 8px;">No</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Kode Peminjaman</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Anggota</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Tanggal Pinjam</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Jatuh Tempo</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Status</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($loans as $loan)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">
                    {{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}
                </td>

                <td style="border: 1px solid #ddd; padding: 8px;">
                    {{ $loan->kode_peminjaman }}
                </td>

                <td style="border: 1px solid #ddd; padding: 8px;">
                    {{ $loan->member->nama ?? '-' }}
                </td>

                <td style="border: 1px solid #ddd; padding: 8px;">
                    {{ $loan->tanggal_pinjam }}
                </td>

                <td style="border: 1px solid #ddd; padding: 8px;">
                    {{ $loan->tanggal_jatuh_tempo }}
                </td>

                <td style="border: 1px solid #ddd; padding: 8px;">
                    @if ($loan->status === 'dikembalikan')
                    <span style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px;">
                        Dikembalikan
                    </span>
                    @elseif ($loan->status === 'terlambat')
                    <span style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px;">
                        Terlambat
                    </span>
                    @else
                    <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px;">
                        Dipinjam
                    </span>
                    @endif
                </td>

                <td style="border: 1px solid #ddd; padding: 8px;">

                    <a href="{{ route('loans.show', $loan->id) }}">
                        Detail
                    </a>
                    |

                    <a href="{{ route('loans.edit', $loan->id) }}">
                        Edit
                    </a>

                    @if ($loan->status !== 'dikembalikan')
                    |

                    <form action="{{ route('loans.kembalikan', $loan->id) }}"
                        method="POST"
                        style="display: inline;">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            style="background: #16a34a; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;"
                            onclick="return confirm('Yakin ingin mengembalikan buku ini?')">
                            Kembalikan
                        </button>
                    </form>
                    @endif

                    @if ($loan->status === 'dikembalikan')
                    |

                    <form action="{{ route('loans.destroy', $loan->id) }}"
                        method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            style="background: #dc2626; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;"
                            onclick="return confirm('Yakin ingin menghapus peminjaman ini?')">
                            Hapus
                        </button>
                    </form>
                    @endif

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7"
                    style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                    Belum ada data peminjaman.
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>

    {{-- Pagination --}}
    <div style="margin-top: 20px;">
        {{ $loans->links() }}
    </div>

</div>
@endsection