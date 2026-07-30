<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfcKartu extends Model
{
    use HasFactory;

    protected $table = 'nfc_kartu';

    protected $fillable = [
        'serial_number',
        'nama_mahasiswa',
        'nim',
    ];
}
