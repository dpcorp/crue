<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    protected $fillable = [
        'ips_id',
        'date',
        'time',
        'hospitalization_adults',
        'hospitalization_obstetrics',
        'hospitalization_pediatrics',
        'uce_adults',
        'uce_neonatal',
        'uce_pediatrics',
        'uci_adults',
        'uci_neonatal',
        'uci_pediatrics',
        'urgency_adults',
        'urgency_pediatrics'
    ];

    public function ips()
    {
        return $this->belongsTo(Ips::class, 'ips_id');
    }
}
