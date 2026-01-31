<?php

namespace App\Listeners\Stock;

use App\Enums\StockMovementType;
use App\Events\Stock\ItemInStockCreated;
use App\Models\ItemInStockMovement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateFirstMovement
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ItemInStockCreated $event): void
    {
        DB::transaction(function () use ($event) {
            ItemInStockMovement::create([
                'movement_type' => StockMovementType::CHECKIN,
                'quantity_moved' => $event->itemInStock->quantity,
                'company_id' => $event->itemInStock->company_id,
                'item_in_stock_id' => $event->itemInStock->id,
            ]);
        });
    }
}
