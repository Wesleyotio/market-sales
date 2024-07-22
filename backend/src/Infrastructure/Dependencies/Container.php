<?php


use App\Infrastructure\Persistence\DatabaseProductInterface;
use App\Drivers\Persistence\DatabaseProduct;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Repositories\ProductRepository;
use App\Application\ProductService;
use App\Infrastructure\Web\Controllers\ProductController;

return [
    DatabaseProductInterface::class => \DI\create(DatabaseProduct::class),
    ProductRepositoryInterface::class => \DI\create(ProductRepository::class)
        ->constructor(\DI\get(DatabaseProductInterface::class)),
    ProductService::class => \DI\create()
        ->constructor(\DI\get(ProductRepositoryInterface::class)),
    ProductController::class => \DI\create()
        ->constructor(\DI\get(ProductService::class)),
];