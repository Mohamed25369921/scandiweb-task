<?php

namespace App\Views;

class ProductView
{
    // Render Product List Page
    public static function renderList(array $products): void
    {
        $basePath = '/scandiweb-task';

        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Product List</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 20px;
                    background-color: #fff;
                    border-bottom: 1px solid #ddd;
                }
                .header h1 {
                    margin: 0;
                    font-size: 1.8rem;
                }
                .product-list {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 20px;
                    padding: 20px;
                }
                .product-card {
                    border: 1px solid #ddd;
                    padding: 20px;
                    border-radius: 8px;
                    text-align: center;
                    background-color: #f9f9f9;
                }
                footer {
                    text-align: center;
                    padding: 10px;
                    background-color: #f8f9fa;
                    border-top: 1px solid #ddd;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Product List</h1>
                <div class="action-buttons">
                    <a href="' . $basePath . '/add-product" class="btn btn-success">Add Product</a>
                    <button id="delete-product-btn" class="btn btn-danger" disabled>Mass Delete</button>
                </div>
            </div>
            <form id="product-list-form" method="POST" action="' . $basePath . '/delete-products">
                <div class="product-list">';
        
        foreach ($products as $product) {
            echo '<div class="product-card">
                <input type="checkbox" class="delete-checkbox" name="ids[]" value="' . htmlspecialchars($product->getSku()) . '">
                <p><strong>SKU:</strong> ' . htmlspecialchars($product->getSku()) . '</p>
                <p>' . htmlspecialchars($product->getName()) . '</p>
                <p><strong>Price:</strong> $' . htmlspecialchars($product->getPrice()) . '</p>
                <p><strong>' . htmlspecialchars($product->getAttribute()) . '</strong></p>
            </div>';
        }

        echo '</div>
            </form>
            <footer>
                <p>Scandiweb Test Assignment</p>
            </footer>
            <script>
                const deleteButton = document.getElementById("delete-product-btn");
                const checkboxes = document.querySelectorAll(".delete-checkbox");

                checkboxes.forEach(cb => cb.addEventListener("change", () => {
                    const isAnyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                    deleteButton.disabled = !isAnyChecked;
                }));

                deleteButton.addEventListener("click", function () {
                    if (confirm("Are you sure you want to delete the selected products?")) {
                        document.getElementById("product-list-form").submit();
                    }
                });
            </script>
        </body>
        </html>';
    }


    // Render Add Product Page
    public static function renderAddForm(): void
    {
        $basePath = '/scandiweb-task';

        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Add Product</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f9;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px 20px;
                    background-color: #fff;
                    border-bottom: 1px solid #ddd;
                }
                .header h1 {
                    margin: 0;
                    font-size: 1.8rem;
                }
                .action-buttons {
                    display: flex;
                    gap: 10px;
                }
                .action-buttons a,
                .action-buttons button {
                    padding: 5px 15px;
                    border: none;
                    border-radius: 4px;
                    font-size: 14px;
                    cursor: pointer;
                }
                .action-buttons .btn-success {
                    background-color: #007bff;
                    color: white;
                }
                .action-buttons .btn-success:hover {
                    background-color: #0056b3;
                }
                .action-buttons .btn-secondary {
                    background-color: #6c757d;
                    color: white;
                }
                .action-buttons .btn-secondary:hover {
                    background-color: #5a6268;
                }
                form {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                form label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }
                form input,
                form select {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 15px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
                .type-specific-fields {
                    border: 1px solid #ddd;
                    padding: 15px;
                    border-radius: 4px;
                    margin-bottom: 15px;
                    background-color: #f9f9f9;
                }
                footer {
                    text-align: center;
                    padding: 10px;
                    background-color: #f8f9fa;
                    border-top: 1px solid #ddd;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Product Add</h1>
                <div class="action-buttons">
                    <button type="submit" form="product_form" class="btn btn-success">Save</button>
                    <a href="' . $basePath . '/" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
            <form id="product_form" method="POST" action="' . $basePath . '/save-product">
                <label for="sku">SKU:</label>
                <input type="text" id="sku" name="sku" required>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="price">Price ($):</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <label for="productType">Type Switcher:</label>
                <select id="productType" name="type" required>
                    <option value="DVD" selected>DVD</option>
                    <option value="Book">Book</option>
                    <option value="Furniture">Furniture</option>
                </select>

                <div id="typeSpecificFields" class="type-specific-fields">
                    <label for="size">Size (MB):</label>
                    <input type="number" id="size" name="size" required>
                    <small>Product description: Enter the size in MB for the DVD.</small>
                </div>
            </form>
            <footer>
                <p>Scandiweb Test Assignment</p>
            </footer>
            <script>
                const productType = document.getElementById("productType");
                const typeSpecificFields = document.getElementById("typeSpecificFields");

                function updateTypeSpecificFields() {
                    const type = productType.value;
                    typeSpecificFields.innerHTML = ""; // Clear fields

                    if (type === "DVD") {
                        typeSpecificFields.innerHTML = `
                            <label for="size">Size (MB):</label>
                            <input type="number" id="size" name="size" required>
                            <small>Product description: Enter the size in MB for the DVD.</small>
                        `;
                    } else if (type === "Book") {
                        typeSpecificFields.innerHTML = `
                            <label for="weight">Weight (Kg):</label>
                            <input type="number" id="weight" name="weight" step="0.01" required>
                            <small>Product description: Enter the weight in Kg for the book.</small>
                        `;
                    } else if (type === "Furniture") {
                        typeSpecificFields.innerHTML = `
                            <label for="height">Height (CM):</label>
                            <input type="number" id="height" name="height" required>
                            <label for="width">Width (CM):</label>
                            <input type="number" id="width" name="width" required>
                            <label for="length">Length (CM):</label>
                            <input type="number" id="length" name="length" required>
                            <small>Product description: Please provide dimensions in HxWxL format.</small>
                        `;
                    }
                }

                // Update fields on page load and dropdown change
                updateTypeSpecificFields();
                productType.addEventListener("change", updateTypeSpecificFields);
            </script>
        </body>
        </html>';
    }
}
