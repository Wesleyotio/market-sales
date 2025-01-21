<?php

declare(strict_types=1);

namespace Tests\Units\Application\UseCases;

use App\Application\UseCases\FindProductUseCase;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FindProductUseCaseTest extends TestCase
{
    
  

    #[DataProvider('valueProvider')]
    public function test_fail_find_product_for_id($id, $expect) 
    {
        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        
        $createProductUseCase = new FindProductUseCase($productRepository);

        $this->expectException($expect);

        $productRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturnCallback(function($idValue) use ($id, $expect){
                if($idValue == $id) {
                    return $expect;
                }
            });
        
        $createProductUseCase->action($id);
        

    }

    public function test_find_product_for_id() 
    {
        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        
        $createProductUseCase = new FindProductUseCase($productRepository);

        $productRepository
                ->expects($this->once())
                ->method('findById')
                ->willReturn(new Product(
                    1,
                    99,
                    1,
                    'MyproductName',
                    99.95,
                    \DateTimeImmutable::createFromFormat('Y-m-d H:i:s','2024-12-10 00:11:58'),
                    \DateTimeImmutable::createFromFormat('Y-m-d H:i:s','2024-12-10 00:11:58')

                ));
        
        $result = $createProductUseCase->action(1);

        $this->assertInstanceOf(Product::class, $result);

    }

    public static function valueProvider()
    {
        return [
            'when_id_does_not_exist' => [ 'id' => 99999, 'expect' => \TypeError::class],
            'when_id_is_invalid' => [ 'id' => -5, 'expect' => \TypeError::class]
            
        ];
    }
}
