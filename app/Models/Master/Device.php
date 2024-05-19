<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Device extends Model
{
    use HasFactory, HasUuids;

    protected $table        = 'tbl_device';
    protected $primaryKey   = 'device_uuid';

    protected $fillable = [
        'device_uuid',
        'device_name',
        'online_status',
        'node_eui'
    ];

    /** Fungsi untuk membuat otomatis pengisian atau perubahan data
     * dari apa yg telah didefinisikan seperti created_by dan updated_by
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by      = auth()->user()->name  ?? 'Admin';
            $model->updated_by      = auth()->user()->name  ?? 'Admin';
        });
    }
}
