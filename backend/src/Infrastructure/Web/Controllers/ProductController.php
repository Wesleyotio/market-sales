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

    public function findById(Request $request, Response $response, array $args): Response 
    {
      

        try {
            //code...
            $productId = $args["id"];
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response->withStatus(400);
        }


        try {
            //code...
            $productId = $args["id"];
            $productEntity = $this->productService->findProductById($productId);
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response->withStatus(500);
        }

        $encodedEntity = json_encode(
            $productEntity,
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedEntity);
        return $response->withStatus(200);
    }
    public function findAll(Request $request, Response $response, array $args): Response 
    {
      

        try {
            //code...
           
            $productsEntities = $this->productService->findAllProducts();
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response->withStatus(500);
        }

        $encodedProducts = json_encode(
            $productsEntities,
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedProducts);
        return $response->withStatus(200);
    }
}