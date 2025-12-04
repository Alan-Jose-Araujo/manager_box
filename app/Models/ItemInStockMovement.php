<?php

namespace App\Models;

use App\Enums\StockMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemInStockMovement extends Model
{
    /** @use HasFactory<\Database\Factories\ItemInStockMovementFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'movement_type',
        'quantity_moved',
        'company_id',
        'item_in_stock_id',
    ];

    public function casts()
    {
        return [
            'movement_type' => StockMovementType::class,
            'quantity_moved' => 'double',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function itemInStock(): HasOne
    {
        return $this->hasOne(ItemInStock::class, 'item_in_stock_id');
    }
}
