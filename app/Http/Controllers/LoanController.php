<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class LoanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman.
     */
    public function index()
    {
        $loans = Loan::with([
            'member',
            'user',
            'loanItems.book'
        ])
            ->latest()
            ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function report(Request $request)
    {
        $body = ['data' => [], 'meta' => null];

        try {
            $response = Http::get(config('services.internal_api.base_url') . '/api/loans', [
                'page' => $request->query('page', 1),
            ]);

            if ($response->successful()) {
                $body = $response->json();
            }
        } catch (ConnectionException $e) {
            // Server internal API (port 8011) tidak bisa dihubungi - tabel laporan tampil kosong.
        }

        return view('loans.report', [
            'loans' => $body['data'] ?? [],
            'meta' => $body['meta'] ?? null,
        ]);
    }

    /**
     * Menampilkan form tambah peminjaman.
     */
    public function create()
    {
        $members = Member::where('status', 'aktif')->get();
        $books = Book::where('stok', '>', 0)->get();

        return view('loans.create', compact('members', 'books'));
    }

    /**
     * Menyimpan data peminjaman.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' =>
            'required|date|after_or_equal:tanggal_pinjam',
            'catatan' => 'nullable|string',
            'books' => 'required|array|min:1',
            'books.*.book_id' => 'required|exists:books,id',
            'books.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {

            $loan = Loan::create([
                'kode_peminjaman' =>
                'PJM-' . now()->format('YmdHis') . '-'
                    . strtoupper(Str::random(4)),

                'member_id' => $validated['member_id'],

                // Menyimpan ID petugas yang sedang login.
                'user_id' => Auth::id(),

                'tanggal_pinjam' => $validated['tanggal_pinjam'],

                'tanggal_jatuh_tempo' =>
                $validated['tanggal_jatuh_tempo'],

                'status' => 'dipinjam',

                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($validated['books'] as $item) {

                $book = Book::whereKey($item['book_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($book->stok < $item['jumlah']) {
                    throw new \Exception(
                        "Stok buku {$book->judul} tidak mencukupi."
                    );
                }

                // Mengurangi stok buku.
                $book->decrement('stok', $item['jumlah']);

                // Menyimpan detail peminjaman.
                LoanItem::create([
                    'loan_id' => $loan->id,
                    'book_id' => $book->id,
                    'jumlah' => $item['jumlah'],
                    'denda' => 0,
                ]);
            }
        });

        return redirect()
            ->route('loans.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail peminjaman.
     */
    public function show(string $id)
    {
        $loan = Loan::with([
            'member',
            'user',
            'loanItems.book'
        ])->findOrFail($id);

        return view('loans.show', compact('loan'));
    }

    /**
     * Menampilkan form edit peminjaman.
     */
    public function edit(string $id)
    {
        $loan = Loan::with([
            'member',
            'user',
            'loanItems.book'
        ])->findOrFail($id);

        $members = Member::where('status', 'aktif')->get();

        $books = Book::all();

        return view(
            'loans.edit',
            compact('loan', 'members', 'books')
        );
    }

    /**
     * Memperbarui data peminjaman.
     */
    public function update(Request $request, string $id)
    {
        $loan = Loan::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' =>
            'required|date|after_or_equal:tanggal_pinjam',
            'catatan' => 'nullable|string',
        ]);

        $loan->update($validated);

        return redirect()
            ->route('loans.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    /**
     * Menghapus data peminjaman.
     */
    public function destroy(string $id)
    {
        $loan = Loan::with('loanItems')->findOrFail($id);

        if ($loan->status !== 'dikembalikan') {
            return redirect()
                ->route('loans.index')
                ->with(
                    'error',
                    'Peminjaman harus dikembalikan sebelum dihapus.'
                );
        }

        DB::transaction(function () use ($loan) {

            $loan->loanItems()->delete();

            $loan->delete();
        });

        return redirect()
            ->route('loans.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }

    /**
     * Memproses pengembalian buku.
     */
    public function kembalikan(string $id)
    {
        $loan = Loan::with('loanItems')->findOrFail($id);

        if ($loan->status === 'dikembalikan') {
            return redirect()
                ->route('loans.index')
                ->with(
                    'error',
                    'Peminjaman ini sudah dikembalikan.'
                );
        }

        DB::transaction(function () use ($loan) {

            foreach ($loan->loanItems as $item) {

                $book = Book::whereKey($item->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Mengembalikan stok buku.
                $book->increment('stok', $item->jumlah);

                // Menyimpan tanggal pengembalian detail.
                $item->update([
                    'tanggal_kembali' => now()->toDateString(),
                ]);
            }

            // Memperbarui data peminjaman.
            $loan->update([
                'tanggal_kembali' => now()->toDateString(),
                'status' => 'dikembalikan',
            ]);
        });

        return redirect()
            ->route('loans.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
