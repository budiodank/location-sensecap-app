<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table        = 'tbl_location';
    public $timestamps      = false;

    protected $fillable = [
        'longitude',
        'latitude',
        'node_eui',
        'created_tm',
    ];

    /** Fungsi untuk membuat otomatis pengisian atau perubahan data
     * dari apa yg telah didefinisikan seperti created_by dan updated_by
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_at  = now();
        });
    }

    public function device()
    {
        return $this->belongsTo('App\Models\Master\Device', 'node_eui', 'node_eui');
    }
}
