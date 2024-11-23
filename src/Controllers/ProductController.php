<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\ProductFactory;

class ProductController
{
    public function listProducts(): array
    {
        return Product::getAll();
    }

    public function saveProduct(array $data): void
    {
        if (Product::skuExists($data['sku'])) {
            // Handle duplicate SKU error
            echo '<script>alert("The SKU already exists. Please use a unique SKU."); window.location.href="/scandiweb-task/add-product";</script>';
            exit;
        }

        $product = ProductFactory::create($data);
        $product->save();
    }

    public function deleteProducts(array $ids): void
    {
        if (!empty($ids)) {
            Product::deleteByIds($ids);
        }
    }
}
