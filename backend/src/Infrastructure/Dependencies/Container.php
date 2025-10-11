<?php

use App\Infrastructure\Persistence\DatabaseProductInterface;
use App\Drivers\Persistence\DatabaseProduct;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Repositories\ProductRepository;
use App\Application\ProductService;
use App\Application\UseCases\CreateProductUseCase;
use App\Application\UseCases\DeleteProductUseCase;
use App\Application\UseCases\FindAllProductUseCase;
use App\Application\UseCases\FindProductUseCase;
use App\Application\UseCases\UpdateProductUseCase;
use App\Infrastructure\Web\Controllers\ProductController;
use Doctrine\Migrations\Configuration\EntityManager\EntityManagerLoader;
use Psr\Container\ContainerInterface;

return [

    EntityManagerLoader::class => function (ContainerInterface $c) {
        $doctrineConfig = require __DIR__ . '/../../../config/doctrine.php';
        return $doctrineConfig();
    },


    DatabaseProductInterface::class => \DI\create(DatabaseProduct::class),
    ProductRepositoryInterface::class => \DI\create(ProductRepository::class)
        ->constructor(\DI\get(DatabaseProductInterface::class)),
    // ProductService::class => \DI\create()
    //     ->constructor(\DI\get(ProductRepositoryInterface::class)),
    CreateProductUseCase::class => \DI\create()
        ->constructor(\DI\get(ProductRepositoryInterface::class)),
    FindProductUseCase::class => \DI\create()
        ->constructor(\DI\get(ProductRepositoryInterface::class)),
    FindAllProductUseCase::class => \DI\create()
        ->constructor(\DI\get(ProductRepositoryInterface::class)),
    UpdateProductUseCase::class => \DI\create()
        ->constructor(\DI\get(ProductRepositoryInterface::class)),
    DeleteProductUseCase::class => \DI\create()
        ->constructor(\DI\get(ProductRepositoryInterface::class)),
    ProductController::class => \DI\create()
        ->constructor(
            \DI\get(CreateProductUseCase::class),
            \DI\get(FindProductUseCase::class),
            \DI\get(FindAllProductUseCase::class),
            \DI\get(UpdateProductUseCase::class),
            \DI\get(DeleteProductUseCase::class),
        ),
];
