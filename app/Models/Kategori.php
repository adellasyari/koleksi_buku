<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'kategoris';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'idkategori';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Satu kategori memiliki banyak buku
     */
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'idkategori');
    }
}
