<?php

namespace App\Models;

use App\Enums\ItemInStockCategoryScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemInStockCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ItemInStockCategoryFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'item_in_stock_categories';

    protected $fillable = [
        'name',
        'description',
        'scope',
        'color_hex_code',
        'is_active',
        'company_id',
        'warehouse_id',
    ];

    protected function casts(): array
    {
        return [
            'scope' => ItemInStockCategoryScope::class,
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

    public function itemsInStock(): BelongsToMany
    {
        return $this->belongsToMany(
            ItemInStock::class,
            'item_in_stock_has_category',
            'item_in_stock_category_id',
            'item_in_stock_id'
        );
    }
}
