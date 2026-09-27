@extends('layouts.app')

@section('content')
<div class="container" style="margin: 20px auto; max-width: 1000px;">
    <h1>Daftar Anggota</h1>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <a href="{{ route('members.create') }}" style="display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">+ Tambah Anggota</a>

        {{-- Form Pencarian Nama --}}
        <form action="{{ route('members.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" placeholder="Cari nama anggota..." value="{{ request('search') }}" style="padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" style="padding: 6px 12px; background: #4b5563; color: white; border: none; border-radius: 4px; cursor: pointer;">Cari</button>
            @if (request('search'))
            <a href="{{ route('members.index') }}" style="padding: 6px 12px; background: #ef4444; color: white; text-decoration: none; border-radius: 4px;">Reset</a>
            @endif
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f3f4f6;">
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">ID</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Nama</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">NIM</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Email</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">No. Telepon</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Alamat</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Status</th>
                <th style="border: 1px solid #ddd; padding: 8px 12px; text-align: left;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->id }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->nama }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->nim }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->email }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->nomor_telepon }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->alamat }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">{{ $member->status }}</td>
                <td style="border: 1px solid #ddd; padding: 8px 12px;">
                    <a href="{{ route('members.show', $member->id) }}">Detail</a> |
                    <a href="{{ route('members.edit', $member->id) }}">Edit</a> |
                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #dc2626; color: #fff; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer;" onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="border: 1px solid #ddd; padding: 12px; text-align: center;">Belum ada data anggota.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $members->appends(request()->query())->links() }}
    </div>
</div>
@endsection