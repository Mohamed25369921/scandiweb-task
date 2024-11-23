<?php

namespace App\Models;

use App\Database\DatabaseConnection;

class FurnitureProduct extends Product
{
    private float $height;
    private float $width;
    private float $length;

    public function __construct(string $sku, string $name, float $price, float $height, float $width, float $length)
    {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getAttribute(): string
    {
        return "Dimensions: {$this->height}x{$this->width}x{$this->length}";
    }

    public function save(): void
    {
        $db = DatabaseConnection::getInstance();
        $query = "INSERT INTO products (sku, name, price, type, height, width, length) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            $this->sku, 
            $this->name, 
            $this->price, 
            'Furniture', 
            $this->height, 
            $this->width, 
            $this->length
        ]);
    }
}
