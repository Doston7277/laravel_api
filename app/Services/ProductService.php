<?php

namespace App\Services;

use App\Models\Product;
use App\ViewModels\JsonApiViewModel;

class ProductService
{
    public function __construct()
    {
        //
    }

    public function create($attributes)
    {
        $product = Product::create($attributes);
        return JsonApiViewModel::getSuccessResponse($product);
    }
    
}
