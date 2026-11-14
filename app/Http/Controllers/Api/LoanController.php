<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['member', 'user', 'loanItems.book'])
            ->latest()
            ->paginate(10);

        return LoanResource::collection($loans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'       => 'required|integer|exists:members,id',
            'user_id'         => 'required|integer|exists:users,id',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'book_ids'        => 'required|array|min:1',
            'book_ids.*'      => 'integer|exists:books,id',
        ], [
            'member_id.required'             => 'Anggota wajib dipilih.',
            'user_id.required'               => 'Petugas (user_id) wajib diisi.',
            'user_id.exists'                 => 'Petugas yang dipilih tidak valid.',
            'tanggal_pinjam.required'        => 'Tanggal pinjam wajib diisi.',
            'tanggal_kembali.required'       => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
            'book_ids.required'              => 'Pilih minimal satu buku.',
        ]);

        $loan = DB::transaction(function () use ($validated) {
            $newLoan = Loan::create([
                'kode_peminjaman'     => 'PJM-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                'member_id'           => $validated['member_id'],
                'user_id'             => $validated['user_id'],
                'tanggal_pinjam'      => $validated['tanggal_pinjam'],
                'tanggal_jatuh_tempo' => $validated['tanggal_kembali'],
                'status'              => 'dipinjam',
            ]);

            foreach ($validated['book_ids'] as $bookId) {
                $book = Book::findOrFail($bookId);
                if ($book->stok > 0) {
                    $book->decrement('stok', 1);
                }

                $newLoan->loanItems()->create([
                    'book_id' => $bookId,
                    'jumlah'  => 1,
                    'denda'   => 0,
                ]);
            }

            return $newLoan;
        });

        $loan->refresh()->load(['member', 'user', 'loanItems.book']);

        return (new LoanResource($loan))->response()->setStatusCode(201);
    }

    public function kembalikan(string $id)
    {
        $loan = Loan::with(['member', 'user', 'loanItems.book'])->findOrFail($id);

        if ($loan->status !== 'dikembalikan') {
            foreach ($loan->loanItems as $item) {
                $item->book?->increment('stok', $item->jumlah ?? 1);
            }
        }

        $loan->update([
            'status'          => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return new LoanResource($loan);
    }
}
