<?php

namespace App\Http\Controllers\Filters;

use App\Models\Product;

class OrderbayFilter
{
    public function newest()
    {
        return Product::orderBy('desc','created_at')->get();
    }
}
