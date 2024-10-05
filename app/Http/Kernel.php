<?php
protected $routeMiddleware = [
    'auth' => App\Http\Middleware\Authenticate::class,
    'jwt.auth' => Tymon\JWTAuth\Http\Middleware\Authenticate::class,
    'jwt.refresh' => Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
];
