<?php

namespace App\Models;

use App\Enums\ItemInStockUnityOfMeasure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemInStock extends Model
{
    /** @use HasFactory<\Database\Factories\ItemInStockFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'items_in_stock';

    protected $fillable = [
        'name',
        'trade_name',
        'description',
        'sku',
        'unity_of_measure',
        'quantity',
        'minimum_quantity',
        'maximum_quantity',
        'illustration_picture_path',
        'cost_price',
        'sale_price',
        'is_active',
        'company_id',
        'warehouse_id',
    ];

    protected function casts(): array
    {
        return [
            'unity_of_measure' => ItemInStockUnityOfMeasure::class,
            'quantity' => 'double',
            'minimum_quantity' => 'double',
            'maximum_quantity' => 'double',
            'cost_price' => 'double',
            'sale_price' => 'double',
            'is_active' => 'boolean',
        ];
    }

    # Relationships.

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    // Get the categories by pivot table.
    public function categories()
    {
        return $this->belongsToMany(
            ItemInStockCategory::class,
            'item_in_stock_has_category',
            'item_in_stock_id',
            'item_in_stock_category_id'
        );
    }
}
