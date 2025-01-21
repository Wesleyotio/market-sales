<?php

declare(strict_types=1);

namespace Tests\Units\Application\UseCases;


use App\Application\UseCases\UpdateProductUseCase;
use App\Domain\Repositories\ProductRepositoryInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TypeError;

class UpdateProductUseCaseTest extends TestCase
{
    
    private ProductRepositoryInterface $productRepository;

    public function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        
    }

    #[DataProvider('valueProvider')]
    public function test_throws_exception_when_any_parameter_for_update_is_invalid($id, $productData) 
    {
        $createProductUseCase = new UpdateProductUseCase($this->productRepository);
        
        $this->expectException(TypeError::class);
        
        $this->productRepository
                ->expects($this->never())
                ->method('update');
        
        $createProductUseCase->action($id, $productData);

    }

    public function test_when_parameters_for_update_is_valid()
    {
        
        $updateProductUseCase = new UpdateProductUseCase($this->productRepository);
        $productData = [    
            'code' => 98, 
            'type_product_id' => 1, 
            'name' => 'ProductName' , 
            'value' => 101.25 
        ];

        $this->productRepository
                ->expects($this->once())
                ->method('update')
                ->willReturn(1);
        
        $result = $updateProductUseCase->action(5,$productData);

        $this->assertEquals(1, $result);
    }
    public function test_when_parameters_for_update_is_invalid_id()
    {
        
        $updateProductUseCase = new UpdateProductUseCase($this->productRepository);
        $productData = [    
            'code' => 60, 
            'type_product_id' => 1, 
            'name' => 'ProductInvalid' , 
            'value' => 101.25 
        ];

        $this->productRepository
                ->expects($this->once())
                ->method('update')
                ->willReturn(null);
        
        $result = $updateProductUseCase->action(99999,$productData);

        $this->assertEquals(null, $result);
    }

    public static function valueProvider()
    {
        return [
            'when_code_is_Invalid' => [ 'id' =>1 ,'productData' => ['code' => 'text', 'type_product_id' => 1, 'name' => 'ProductName' , 'value' => 99.9 ] ],

            'when_type_product_is_invalid' => [ 'id' => 2 ,'productData' => [ 'code' => 100, 'type_product_id' => 'text', 'name' => 'ProductName' , 'value' => 98.7 ] ],

            'when_name_is_invalid' => [ 'id' => 3 ,'productData' => [ 'code' => 99, 'type_product_id' => 1, 'name' => 25 , 'value' => 87.6 ] ],

            'when_value_is_invalid' => [ 'id' => 4 ,'productData' => [ 'code' => 98, 'type_product_id' => 1, 'name' => 'ProductName' , 'value' => 'text' ] ],
            
        ];
    }
}
