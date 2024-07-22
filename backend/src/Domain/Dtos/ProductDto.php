<?php

declare(strict_types =1);

namespace App\Domain\Dtos;

class ProductDto 
{
   
    private int $code;
    private int $typeProductId; 
    private string $name;
    private float $value;
    
    public function __construct(
        int $code,
        int $typeProductId,
        string $name,
        float $value, 
       
    ) {
      
        $this->code = $code;
        $this->typeProductId = $typeProductId;
        $this->name = $name;
        $this->value = $value;
     
    }

    public function getCode(): int
    {
        return $this->code;
    }
    
    public function getTypeProductId(): int
    {
        return $this->typeProductId;
    }
    
    public function getName(): string 
    {
        return $this->name;
    }
    
    public function getValue(): float 
    {
        return $this->value;
    }
        
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function setTypeProductId(int $typeProductId): void 
    {
        $this->typeProductId = $typeProductId;
    }
    
    public function setName(string $name): void 
    {
        $this->name = $name;
    }
    
    public function setValue(float $value):void 
    {
        $this->value = $value;
    }
    
    
}