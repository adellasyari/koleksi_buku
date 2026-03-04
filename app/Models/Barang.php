<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barang';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_barang';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * We set false because DB trigger handles generation.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Disable Laravel timestamps (DB uses a single `timestamp` column).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_barang',
        'nama',
        'harga',
        'timestamp',
    ];
}
