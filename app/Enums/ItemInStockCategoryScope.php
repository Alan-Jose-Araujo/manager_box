<?php

namespace App\Enums;

enum ItemInStockCategoryScope: string
{
    case GLOBAL = 'global';
    case WAREHOUSE = 'warehouse';
}
