<?php

namespace App\Enums;

enum StockMovementType: string
{
    case CHECKIN = 'checkin';

    case CHECKOUT = 'checkout';
}
