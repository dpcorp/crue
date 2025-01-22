<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutOfService extends Model
{
    protected $fillable = [
        'ips_id',
        'date',
        'time',
        'quantity',
        'reason'
    ];

    public function ips()
    {
        return $this->belongsTo(Ips::class, 'ips_id');
    }
}
