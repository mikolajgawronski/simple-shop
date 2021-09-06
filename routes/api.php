<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/** @var Router $router */
$router = app()->make(Router::class);

$router->middleware("auth:sanctum")->get("/user", fn(Request $request) => $request->user());

$router->prefix("products")->group(function (Router $router) {
    $router->get("{id?}", [ProductController::class, "index"]);
    $router->post("create", [ProductController::class, "store"]);
    $router->put("update/{id}", [ProductController::class, "update"]);
    $router->delete("delete/{id}", [ProductController::class, "destroy"]);
});
