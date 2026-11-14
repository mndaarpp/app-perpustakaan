<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'kode_peminjaman'      => $this->kode_peminjaman,
            'member'               => [
                'id'   => $this->member?->id,
                'nama' => $this->member?->nama,
            ],
            'petugas'              => [
                'id'   => $this->user?->id,
                'name' => $this->user?->name,
            ],
            'tanggal_pinjam'       => $this->tanggal_pinjam,
            'tanggal_kembali'      => $this->tanggal_kembali ?? $this->tanggal_jatuh_tempo,
            'tanggal_dikembalikan' => $this->tanggal_dikembalikan,
            'status'               => $this->status,
            'books'                => $this->loanItems->map(fn($item) => [
                'id'     => $item->book?->id,
                'judul'  => $item->book?->judul,
                'jumlah' => $item->jumlah ?? 1,
            ]),
        ];
    }
}
