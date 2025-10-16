<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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
        'zip_code',
        'complement',
        'city',
        'state',
        'addressable_type',
        'addressable_id',
    ];

    # Relationships.

    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable');
    }

    public function companies(): MorphToMany
    {
        return $this->morphedByMany(Company::class, 'addressable');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'addressable');
    }

    public function wareHouses(): MorphToMany
    {
        return $this->morphedByMany(WareHouse::class, 'addressable');
    }
}
