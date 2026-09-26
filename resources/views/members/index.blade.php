@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')

<h1>Daftar Anggota</h1>

<p>
    <a href="{{ route('members.create') }}" class="btn">
        + Tambah Anggota
    </a>
</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>Nomor Telepon</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($members as $member)
        <tr>
            <td>{{ $member['id'] }}</td>
            <td>{{ $member['nama'] }}</td>
            <td>{{ $member['nim'] }}</td>
            <td>{{ $member['email'] }}</td>
            <td>{{ $member['nomor_telepon'] }}</td>
            <td>{{ $member['alamat'] }}</td>
            <td>{{ $member['status'] }}</td>
            <td>
                <a href="{{ route('members.show', $member['id']) }}">
                    Detail
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Belum ada data anggota.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection