<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/** @var Router $router */
$router = app()->make(Router::class);

$router->middleware("auth:sanctum")->get("/user", fn(Request $request) => $request->user());

$router->get("/products", [ProductController::class, "index"]);
