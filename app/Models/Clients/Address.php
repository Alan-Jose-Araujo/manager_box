<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'street', 'building_number', 'neighborhood', 'city', 'state',
        'addressable_type', 'addressable_id'
    ];

    public function addressable() {
        return $this->morphTo();
    }
}

