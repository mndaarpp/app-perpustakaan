<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'book_id',
        'jumlah',
        'tanggal_kembali',
        'denda',
    ];
}
