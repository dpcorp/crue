<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ips extends Model
{
    protected $table = 'ips';

    protected $fillable = [
        'name',
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
}
