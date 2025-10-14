<?php

namespace App\Models\Stocks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Stocks\Warehouse;
use App\Models\Stocks\ItemInStockCategory;
use App\Models\Clients\Address;
use App\Models\Clients\Company;

class ItemInStock extends Model
{
  use HasFactory, SoftDeletes;

    protected $fillable = [
        'trade_name', 'description', 'sku', 'unity_of_measure',
        'quantity', 'minimum_quantity', 'cost_price', 'sale_price',
        'item_in_stock_category_id', 'company_id', 'warehouse_id'
    ];

    public function category() {
        return $this->belongsTo(ItemInStockCategory::class, 'item_in_stock_category_id');
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }
    
    public function categories() {
        return $this->belongsToMany(
            ItemInStockCategory::class,
            'item_in_stock_has_category',
            'item_in_stock_id',
            'item_in_stock_category_id'
        )->withTimestamps()->withTrashed();
    }
}