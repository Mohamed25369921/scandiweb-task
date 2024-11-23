<?php

namespace App\Models;

use App\Database\DatabaseConnection;

abstract class Product
{
    protected string $sku;
    protected string $name;
    protected float $price;

    public function __construct(string $sku, string $name, float $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    // Accessors
    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    // Abstract method to handle type-specific attributes
    abstract public function getAttribute(): string;

    abstract public function save(): void;

    public static function skuExists(string $sku): bool
    {
        $db = DatabaseConnection::getInstance();
        $query = "SELECT COUNT(*) FROM products WHERE sku = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$sku]);

        return $stmt->fetchColumn() > 0;
    }

    // Static method to retrieve all products
    public static function getAll(): array
    {
        $db = DatabaseConnection::getInstance();
        $query = "SELECT * FROM products ORDER BY id";
        $stmt = $db->query($query);

        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = ProductFactory::create($row);
        }

        return $products;
    }

    public static function deleteByIds(array $ids): void
    {
        $db = DatabaseConnection::getInstance();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM products WHERE sku IN ($placeholders)";
        $stmt = $db->prepare($query);
        $stmt->execute($ids);
    }


}
