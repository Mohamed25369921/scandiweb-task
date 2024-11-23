<?php

require_once __DIR__ . '/../autoload.php';

use App\Controllers\ProductController;
use App\Views\ProductView;

// Define the base path
$basePath = '/scandiweb-task';

// Remove the base path from the request URI
$requestUri = str_replace($basePath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Define routes
$routes = [
    '/' => function () {
        $controller = new ProductController();
        $products = $controller->listProducts();
        ProductView::renderList($products);
    },
    '/add-product' => function () {
        ProductView::renderAddForm();
    },
    '/save-product' => function () {
        $controller = new ProductController();
        $controller->saveProduct($_POST);
        header('Location: /scandiweb-task/');
        exit;
    },
    '/delete-products' => function () {
        $controller = new ProductController();
        $controller->deleteProducts($_POST['ids']);
        header('Location: /scandiweb-task/');
        exit;
    },
];

// Handle routing
if (isset($routes[$requestUri])) {
    $routes[$requestUri]();
} else {
    http_response_code(404);
    echo "404 - Page Not Found";
}
