<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'bukus';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'idbuku';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'idkategori',
        'kode',
        'judul',
        'pengarang',
    ];

    /**
     * Buku belongs to Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori');
    }
}
