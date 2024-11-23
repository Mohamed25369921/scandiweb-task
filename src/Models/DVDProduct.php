<?php

namespace App\Models;

use App\Database\DatabaseConnection;

class DVDProduct extends Product
{
    private int $size;

    public function __construct(string $sku, string $name, float $price, int $size)
    {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function getAttribute(): string
    {
        return "Size: {$this->size} MB";
    }

    public function save(): void
    {
        $db = DatabaseConnection::getInstance();
        $stmt = $db->prepare("INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$this->sku, $this->name, $this->price, 'DVD', $this->size]);
    }
}
