<?php

namespace App\Drivers\Routes;

use App\Infrastructure\Web\Controllers\ProductController;
use App\Infrastructure\Web\Controllers\SaleController;
use App\Infrastructure\Web\Controllers\TaxController;
use App\Infrastructure\Web\Controllers\TypeProductController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app) {

    $app->group('/v1', function (RouteCollectorProxy $versionOne) {

        $versionOne->post('/products', [ProductController::class, 'create']);
        $versionOne->get('/products', [ProductController::class, 'findAll']);
        $versionOne->get('/products/{id:[0-9]+}', [ProductController::class, 'findById']);
        $versionOne->put('/products/{id:[0-9]+}', [ProductController::class, 'updateAll']);
        $versionOne->patch('/products/{id:[0-9]+}', [ProductController::class, 'update']);
        $versionOne->delete('/products/{id:[0-9]+}', [ProductController::class, 'delete']);

        $versionOne->post('/types', [TypeProductController::class, 'create']);
        $versionOne->get('/types/{id:[0-9]+}', [TypeProductController::class, 'findById']);
        $versionOne->get('/types', [TypeProductController::class, 'findAll']);
        $versionOne->patch('/types/{id:[0-9]+}', [TypeProductController::class, 'update']);
        $versionOne->delete('/types/{id:[0-9]+}', [TypeProductController::class, 'delete']);

        $versionOne->post('/taxes', [TaxController::class, 'create']);
        $versionOne->get('/taxes/{id:[0-9]+}', [TaxController::class, 'findById']);
        $versionOne->get('/taxes', [TaxController::class, 'findAll']);
        $versionOne->put('/taxes/{id:[0-9]+}', [TaxController::class, 'updateAll']);
        $versionOne->patch('/taxes/{id:[0-9]+}', [TaxController::class, 'update']);
        $versionOne->delete('/taxes/{id:[0-9]+}', [TaxController::class, 'delete']);

        $versionOne->post('/sales/order', [SaleController::class, 'order']);
        $versionOne->post('/sales/pay', [SaleController::class, 'checkout']);
        $versionOne->get('/sales', [SaleController::class, 'findAll']);
        $versionOne->get('/sales/{id:[0-9]+}', [SaleController::class, 'findById']);
    });
};
