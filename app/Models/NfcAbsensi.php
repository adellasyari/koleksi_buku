<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfcAbsensi extends Model
{
    use HasFactory;

    protected $table = 'nfc_absensi';

    protected $fillable = [
        'serial_number',
        'waktu_absen',
    ];
}
