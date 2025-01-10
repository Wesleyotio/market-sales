<?php

namespace App\Infrastructure\Web\Controllers;

use App\Application\ProductService;
use App\Infrastructure\Exceptions\ClientException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductController
{
    private ProductService $productService;


    public function __construct(
        ProductService $productService,
    ) {
        $this->productService = $productService;
    }

    public function create(Request $request, Response $response): Response
    {
        $dataProduct = $request->getParsedBody();
        $response = $response->withHeader('Content-Type', 'application/json');

        try {
            //code...
            $this->productService->createProduct($dataProduct);
        } catch (\TypeError $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\APP\Application\Exceptions\ProductException $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\APP\Infrastructure\Exceptions\DataBaseException $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        $encodedEntityCreated = json_encode(
            [ 'message' => 'Product created successfully!'],
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedEntityCreated);
        return $response->withStatus(ResponseCode::HTTP_CREATED);
    }

    public function findById(Request $request, Response $response, array $args): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json');

        try {
            $productId = $args["id"];

            if ($productId <= 0) {
                throw new ClientException("Id provider is invalid");
            }

            $productEntity = $this->productService->findProductById($productId);
        } catch (\App\Infrastructure\Exceptions\ClientException $ex) {
            $messageException = json_encode(
                ["error" => $ex->getMessage()],
                JSON_THROW_ON_ERROR
            );


            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\App\Infrastructure\Exceptions\DataBaseException $th) {
            $messageException = json_encode(
                [
                    'error' => $th->getMessage()
                ],
                JSON_THROW_ON_ERROR
            );

                $response->getBody()->write($messageException);
            return $response->withStatus($th->getCode());
        } catch (\Throwable $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        $encodedEntity = json_encode(
            $productEntity,
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedEntity);
        return $response->withStatus(ResponseCode::HTTP_OK);
    }
    public function findAll(Request $request, Response $response, array $args): Response
    {

        $response = $response->withHeader('Content-Type', 'application/json');

        try {
            //code...

            $productsEntities = $this->productService->findAllProducts();
        } catch (\Throwable $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );
            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        $encodedProducts = json_encode(
            $productsEntities,
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedProducts);
        return $response->withStatus(ResponseCode::HTTP_OK);
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json');
        try {
            //code...
            $productId = $args["id"];

            if ($productId <= 0) {
                throw new ClientException("Id provider is invalid");
            }

            $productData = $request->getParsedBody();

            if ($this->productService->updateProduct($productId, $productData) == null) {
                $messageException = json_encode(
                    ["error" => "o matching rows found for update"],
                    JSON_THROW_ON_ERROR
                );

                $response->getBody()->write($messageException);
                return $response->withStatus(ResponseCode::HTTP_NOT_FOUND);
            };
        } catch (\App\Infrastructure\Exceptions\ClientException $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\TypeError $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\APP\Application\Exceptions\ProductException $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\APP\Infrastructure\Exceptions\DataBaseException $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }


        return $response->withStatus(ResponseCode::HTTP_NO_CONTENT);
    }

    public function updateALL(Request $request, Response $response, array $args): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json');
        try {
            //code...
            $productId = $args["id"];

            if ($productId <= 0) {
                throw new ClientException("Id provider is invalid", ResponseCode::HTTP_BAD_REQUEST);
            }

            $productData = $request->getParsedBody();

            if ($this->productService->updateProductAll($productId, $productData) == null) {
                $messageException = json_encode(
                    ["error" => "o matching rows found for update"],
                    JSON_THROW_ON_ERROR
                );


                $response->getBody()->write($messageException);
                return $response->withStatus(ResponseCode::HTTP_NOT_FOUND);
            };
        } catch (\App\Infrastructure\Exceptions\ClientException $ex) {
            $messageException = json_encode(
                ["error" => $ex->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\TypeError $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\APP\Application\Exceptions\ProductException $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\APP\Infrastructure\Exceptions\DataBaseException $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }


        return $response->withStatus(ResponseCode::HTTP_NO_CONTENT);
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json');

        try {
            $productId = $args["id"];

            if ($productId <= 0) {
                throw new ClientException("Id provider is invalid");
            }

            if ($this->productService->deleteProduct($productId) == null) {
                $messageException = json_encode(
                    ["error" => "id does not match any item"],
                    JSON_THROW_ON_ERROR
                );


                $response->getBody()->write($messageException);
                return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
            };
        } catch (\App\Infrastructure\Exceptions\ClientException $ex) {
            $messageException = json_encode(
                ["error" => $ex->getMessage()],
                JSON_THROW_ON_ERROR
            );


            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (\App\Infrastructure\Exceptions\DataBaseException $th) {
            $messageException = json_encode(
                [
                    'error' => $th->getMessage()
                ],
                JSON_THROW_ON_ERROR
            );

                $response->getBody()->write($messageException);
            return $response->withStatus($th->getCode());
        } catch (\Throwable $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );

            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        $encodedEntity = json_encode(
            [ 'message' => 'Product deleted successfully!'],
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedEntity);
        return $response->withStatus(ResponseCode::HTTP_OK);
    }
}
