<?php

namespace App\Infrastructure\Web\Controllers;

use App\Application\ProductService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductController 
{
    private ProductService $productService;
   

    public function __construct(
        ProductService $productService,
    
    )
    {
        $this->productService = $productService;
        
    }

    public function create(Request $request, Response $response): Response 
    {
        $dataProduct = $request->getParsedBody();

        try {
            //code...
            $this->productService->createProduct($dataProduct);

        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response->withStatus(500);
        }
        $response->getBody()->write("Product created successfully!");
        return $response->withStatus(201);
    }
}