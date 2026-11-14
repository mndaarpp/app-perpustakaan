<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $memberIds = Member::pluck('id');
        $userIds = User::pluck('id');
        $bookIds = Book::pluck('id');

        for ($i = 0; $i < 10; $i++) {
            $tanggalPinjam = now()->subDays(fake()->numberBetween(1, 30));
            $tanggalJatuhTempo = $tanggalPinjam->copy()->addDays(7);
            $status = fake()->randomElement(['dipinjam', 'dikembalikan', 'dikembalikan', 'terlambat']);
            $tanggalKembali = $status === 'dikembalikan'
                ? $tanggalJatuhTempo->copy()->subDays(fake()->numberBetween(0, 3))->toDateString()
                : null;

            $loan = Loan::create([
                'kode_peminjaman' => 'PJM-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)) . $i,
                'member_id' => $memberIds->random(),
                'user_id' => $userIds->random(),
                'tanggal_pinjam' => $tanggalPinjam->toDateString(),
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo->toDateString(),
                'tanggal_kembali' => $tanggalKembali,
                'status' => $status,
            ]);

            $bookIds->random(fake()->numberBetween(1, min(3, $bookIds->count())))
                ->each(fn($bookId) => $loan->loanItems()->create([
                    'book_id' => $bookId,
                    'jumlah' => 1,
                ]));
        }
    }
}
