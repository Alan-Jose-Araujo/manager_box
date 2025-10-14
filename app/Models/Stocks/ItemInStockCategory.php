<?php

namespace App\Models\Stocks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Stocks\ItemInStock;
use App\Models\Clients\Company;

class ItemInStockCategory extends Model
{
   use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'scope', 
        'color_hex_code', 'is_active', 'company_id'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function itemInStock() {
        return $this->hasMany(ItemInStock::class);
    }
}
