<?php

namespace App\Models;

use App\Database\DatabaseConnection;

class BookProduct extends Product
{
    private float $weight;

    public function __construct(string $sku, string $name, float $price, float $weight)
    {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function getAttribute(): string
    {
        return "Weight: {$this->weight} Kg";
    }

    public function save(): void
    {
        $db = DatabaseConnection::getInstance();
        $query = "INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->sku, $this->name, $this->price, 'Book', $this->weight]);
    }
}
