@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 20px auto;">
    <h1>Detail Anggota</h1>
    <p><a href="{{ route('members.index') }}">&larr; Kembali</a></p>

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

    <a href="{{ route('members.edit', $member->id) }}" style="display: inline-block; margin-top: 16px; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 4px;">Edit Anggota</a>
</div>
@endsection