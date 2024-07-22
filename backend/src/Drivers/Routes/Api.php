<?php

namespace App\Drivers\Routes;

use App\Infrastructure\Web\Controllers\ProductController;
use Slim\App;

return static function (App $app) {

    $app->post('/products', [ProductController::class, 'create']);

};

