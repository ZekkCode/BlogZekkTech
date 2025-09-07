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

// Check session
$session = app('session');
echo "Session driver: " . config('session.driver') . "\n";
echo "Session cookie name: " . config('session.cookie') . "\n";

// Testing login manually
$authGuard = app('auth');
echo "Auth guard: " . config('auth.defaults.guard') . "\n";

// Check if admin middleware exists
$middleware = app('router')->getMiddleware();
echo "Middlewares: " . implode(', ', array_keys($middleware)) . "\n";
