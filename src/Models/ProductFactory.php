<?php

namespace App\Models;

class ProductFactory
{
    private static array $productTypes = [
        'DVD' => DVDProduct::class,
        'Book' => BookProduct::class,
        'Furniture' => FurnitureProduct::class,
    ];

    public static function create(array $row): Product
    {
        $type = $row['type'];

        if (!isset(self::$productTypes[$type])) {
            throw new \InvalidArgumentException("Invalid product type from database: {$type}");
        }

        $className = self::$productTypes[$type];

        return match ($type) {
            'DVD' => new $className($row['sku'], $row['name'], $row['price'], $row['size']),
            'Book' => new $className($row['sku'], $row['name'], $row['price'], $row['weight']),
            'Furniture' => new $className(
                $row['sku'],
                $row['name'],
                $row['price'],
                $row['height'],
                $row['width'],
                $row['length']
            ),
        };
    }
}
