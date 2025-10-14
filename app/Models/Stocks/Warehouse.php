<?php

namespace App\Models\Stocks;

use Illuminate\Database\Eloquent\Model;
use App\Models\Clients\Company;
use App\Models\Clients\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Stocks\ItemInStock;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'is_default', 
        'is_active', 'company_id'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function addresses() {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function itemInStock(){
        return $this->hasMany(ItemInStock::class);
    }
}

