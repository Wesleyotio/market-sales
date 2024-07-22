<?php

use App\Infrastructure\Web\Controllers\ProductController;
use Slim\Factory\AppFactory;

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../src/Infrastructure/Dependencies/Container.php');
$container = $containerBuilder->build();

// try {
//     $controller = $container->get(ProductController::class);
//     var_dump($controller);
// } catch (Exception $e) {
//     var_dump($e->getMessage());
//     var_dump($e->getTraceAsString());
// }


AppFactory::setContainer($container);

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$routes = require __DIR__ . "/../src/Drivers/Routes/Api.php";

$routes($app);

return $app;