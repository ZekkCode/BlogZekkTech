<?php
require __DIR__ . "/vendor/autoload.php";
$app = require_once __DIR__ . "/bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Illuminate\Http\Request::capture());

// Block in production for safety
if (app()->environment('production') || !config('app.debug')) {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

// Dapatkan middleware yang terdaftar
$router = app("router");
$middlewares = $router->getMiddleware();
echo "Registered middlewares: " . implode(", ", array_keys($middlewares)) . "\n";
if (isset($middlewares["admin"])) {
    echo "Admin middleware class: " . get_class($middlewares["admin"]) . "\n";
} else {
    echo "Admin middleware is not registered!\n";
}

// Daftar semua rute
$routes = $router->getRoutes();
foreach ($routes as $route) {
    if (strpos($route->uri, "admin") !== false) {
        echo "Route: {$route->uri} | Method: " . implode(",", $route->methods) . " | Action: " . ($route->action["controller"] ?? "Closure") . "\n";
    }
}
