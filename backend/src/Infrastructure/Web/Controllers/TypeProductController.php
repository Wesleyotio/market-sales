<?php

namespace App\Infrastructure\Web\Controllers;

use App\Application\UseCases\CreateTypeProductUseCase;
use App\Application\UseCases\DeleteTypeProductUseCase;
use App\Application\UseCases\FindAllTypeProductUseCase;
use App\Application\UseCases\FindTypeProductUseCase;
use App\Application\UseCases\UpdateTypeProductUseCase;
use App\Application\Dtos\TypeProductDto;
use App\Application\Dtos\TypeProductUpdateDto;
use App\Application\Exceptions\TypeProductException;
use App\Infrastructure\Exceptions\ClientException;
use App\Infrastructure\Exceptions\DataBaseException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TypeProductController
{
    public function __construct(
        private CreateTypeProductUseCase $createTypeProductUseCase,
        // private FindTypeProductUseCase $findTypeProductUseCase,
        private FindAllTypeProductUseCase $findAllTypeProductUseCase
        // private UpdateTypeProductUseCase $updateTypeProductUseCase
        // private DeleteTypeProductUseCase $deleteTypeProductUseCase,
    ) {
    }

    public function create(Request $request, Response $response): Response
    {

        $response = $response->withHeader('Content-Type', 'application/json');

        try {
            $typeProductData = formatRequestInTypeProductData($request);

            $typeProductDto = TypeProductDto::fromRequest($typeProductData);

            $this->createTypeProductUseCase->action($typeProductDto);
        } catch (TypeProductException | \TypeError $th) {
            $response->getBody()->write(
                json_encode(
                    [
                    'error' => $th->getMessage()
                    ],
                    JSON_THROW_ON_ERROR
                )
            );

            return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
        } catch (DataBaseException | \Throwable $th) {
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
            [ 'message' => 'Type of product created successfully!'],
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedEntityCreated);
        return $response->withStatus(ResponseCode::HTTP_CREATED);
    }

    // /**
    // * @param Response $response
    // * @param array{id: int} $args
    // * @return Response
    // */
    // public function findById(Request $request, Response $response, array $args): Response
    // {
    //     $response = $response->withHeader('Content-Type', 'application/json');

    //     try {
    //         $taxId = formatArgsForId($args);

    //         $taxEntity = $this->findTaxUseCase->action($taxId);
    //     } catch (\InvalidArgumentException | ClientException $ex) {
    //         $messageException = json_encode(
    //             ["error" => $ex->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
    //     } catch (\App\Infrastructure\Exceptions\DataBaseException $th) {
    //         $messageException = json_encode(
    //             ["error" => $th->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus($th->getCode());
    //     } catch (\Throwable $th) {
    //         $messageException = json_encode(
    //             ["error" => $th->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
    //     }

    //     $encodedEntity = json_encode(
    //         $taxEntity->toArray(),
    //         JSON_THROW_ON_ERROR
    //     );

    //     $response->getBody()->write($encodedEntity);
    //     return $response->withStatus(ResponseCode::HTTP_OK);
    // }

    /**
    * @param Response $response
    * @return Response
    */
    public function findAll(Request $request, Response $response): Response
    {

        $response = $response->withHeader('Content-Type', 'application/json');

        try {
            $typeProductsEntities = $this->findAllTypeProductUseCase->action();
        } catch (\Throwable $th) {
            $messageException = json_encode(
                ["error" => $th->getMessage()],
                JSON_THROW_ON_ERROR
            );
            $response->getBody()->write($messageException);
            return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        $encodedTypeProducts = json_encode(
            $typeProductsEntities,
            JSON_THROW_ON_ERROR
        );

        $response->getBody()->write($encodedTypeProducts);
        return $response->withStatus(ResponseCode::HTTP_OK);
    }

    // /**
    // * @param Request $request
    // * @param Response $response
    // * @param array{id: int} $args
    // * @return Response
    // */
    // public function update(Request $request, Response $response, array $args): Response
    // {
    //     $response = $response->withHeader('Content-Type', 'application/json');

    //     try {
    //         $taxId = formatArgsForId($args);

    //         $taxData = formatRequestInTaxDataUpdate($request);

    //         $taxUpdateDto = TaxUpdateDto::fromRequest($taxData);

    //         if ($this->updateTaxUseCase->action($taxId, $taxUpdateDto->toArray()) == null) {
    //             $messageException = json_encode(
    //                 ["error" => "o matching rows found for update"],
    //                 JSON_THROW_ON_ERROR
    //             );

    //             $response->getBody()->write($messageException);
    //             return $response->withStatus(ResponseCode::HTTP_NOT_FOUND);
    //         };
    //     } catch (ClientException | TaxException | \TypeError  $th) {
    //         $messageException = json_encode(
    //             ["error" => $th->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
    //     } catch (DataBaseException | \Throwable $th) {
    //         $messageException = json_encode(
    //             ["error" => $th->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
    //     }

    //     return $response->withStatus(ResponseCode::HTTP_NO_CONTENT);
    // }

    // /**
    // * @param Request $request
    // * @param Response $response
    // * @param array{id: int} $args
    // * @return Response
    // */
    // public function updateALL(Request $request, Response $response, array $args): Response
    // {
    //     $response = $response->withHeader('Content-Type', 'application/json');

    //     try {
    //         $taxId = formatArgsForId($args);

    //         $taxData = formatRequestInTaxDataUpdate($request);

    //         $taxUpdateDto = TaxUpdateDto::fromRequest($taxData);

    //         if ($this->updateTaxUseCase->action($taxId, $taxUpdateDto->toArray()) == null) {
    //             $messageException = json_encode(
    //                 ["error" => "o matching rows found for update"],
    //                 JSON_THROW_ON_ERROR
    //             );

    //             $response->getBody()->write($messageException);
    //             return $response->withStatus(ResponseCode::HTTP_NOT_FOUND);
    //         };
    //     } catch (\InvalidArgumentException | ClientException | TaxException | \TypeError $ex) {
    //         $messageException = json_encode(
    //             ["error" => $ex->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
    //     } catch (DataBaseException | \Throwable $th) {
    //         $response->getBody()->write(
    //             json_encode(
    //                 [ "error" => $th->getMessage()],
    //                 JSON_THROW_ON_ERROR
    //             )
    //         );
    //         return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    //     return $response->withStatus(ResponseCode::HTTP_NO_CONTENT);
    // }

    // /**
    // * @param Response $response
    // * @param array{id: int} $args
    // * @return Response
    // */
    // public function delete(Request $request, Response $response, array $args): Response
    // {
    //     $response = $response->withHeader('Content-Type', 'application/json');

    //     try {
    //         $taxId = formatArgsForId($args);

    //         if ($this->deleteTaxUseCase->action($taxId) == null) {
    //             $messageException = json_encode(
    //                 ["error" => "id does not match any item"],
    //                 JSON_THROW_ON_ERROR
    //             );

    //             $response->getBody()->write($messageException);
    //             return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
    //         };
    //     } catch (\App\Infrastructure\Exceptions\ClientException $ex) {
    //         $messageException = json_encode(
    //             ["error" => $ex->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus(ResponseCode::HTTP_BAD_REQUEST);
    //     } catch (\App\Infrastructure\Exceptions\DataBaseException $th) {
    //         $messageException = json_encode(
    //             [
    //                 'error' => $th->getMessage()
    //             ],
    //             JSON_THROW_ON_ERROR
    //         );

    //             $response->getBody()->write($messageException);
    //         return $response->withStatus($th->getCode());
    //     } catch (\Throwable $th) {
    //         $messageException = json_encode(
    //             ["error" => $th->getMessage()],
    //             JSON_THROW_ON_ERROR
    //         );

    //         $response->getBody()->write($messageException);
    //         return $response->withStatus(ResponseCode::HTTP_INTERNAL_SERVER_ERROR);
    //     }

    //     $encodedEntity = json_encode(
    //         [ "message" => "Tax deleted successfully!"],
    //         JSON_THROW_ON_ERROR
    //     );

    //     $response->getBody()->write($encodedEntity);
    //     return $response->withStatus(ResponseCode::HTTP_OK);
    // }
}
