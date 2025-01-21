<?php

declare(strict_types=1);

namespace Tests\Units\Application\UseCases;

use App\Application\UseCases\CreateProductUseCase;
use App\Domain\Repositories\ProductRepositoryInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TypeError;

class CreateProductUseCaseTest extends TestCase
{
    
    private ProductRepositoryInterface $productRepository;

    public function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        
    }

    #[DataProvider('valueProvider')]
    public function test_throws_exception_when_any_parameter_is_invalid($code, $type_product_id, $name, $value) 
    {
        $createProductUseCase = new CreateProductUseCase($this->productRepository);
        
        $this->expectException(TypeError::class);
        
        $this->productRepository
                ->expects($this->never())
                ->method('create');
        
        $createProductUseCase->action($code, $type_product_id, $name, $value);

    }

    public function test_when_parameters_is_valid()
    {
        
        $createProductUseCase = new CreateProductUseCase($this->productRepository);
        
      
        $this->productRepository
                ->expects($this->once())
                ->method('create');
        
        $createProductUseCase->action(97, 1, 'productName', 76.5);
    }

    public static function valueProvider()
    {
        return [
            'when_code_is_Invalid' => [ 'code' => 'text', 'type_product_id' => 1, 'name' => 'ProductName' , 'value' => 99.9 ],

            'when_type_product_is_invalid' => [ 'code' => 100, 'type_product_id' => 'text', 'name' => 'ProductName' , 'value' => 98.7 ],

            'when_name_is_invalid' => [ 'code' => 99, 'type_product_id' => 1, 'name' => 25 , 'value' => 87.6 ],

            'when_value_is_invalid' => [ 'code' => 98, 'type_product_id' => 1, 'name' => 'ProductName' , 'value' => 'text' ],
            
        ];
    }
}
