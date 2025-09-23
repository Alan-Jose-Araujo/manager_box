<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'street',
        'building_number',
        'neighborhood',
        'city',
        'state',
        'addressable_type',
        'addressable_id',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable');
    }
}
