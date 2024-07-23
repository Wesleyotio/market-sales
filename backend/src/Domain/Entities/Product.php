<?php

namespace App\Domain\Entities;

use DateTime;

class Product 
{
    private readonly int $id;
    private int $code;
    private readonly int $typeProductId; 
    private string $name;
    private float $value;
    private readonly DateTime $createdAt;
    private DateTime $updatedAt;
    private DateTime $deletedAt;

    public function __construct(
        int $id, 
        int $code,
        int $typeProductId,
        string $name,
        float $value, 
        DateTime $createdAt, 
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->typeProductId = $typeProductId;
        $this->name = $name;
        $this->value = $value;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
       
    }
    
    public function getId(): int 
    {
        return $this->id;
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
    
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
    public function getDeletedAt(): DateTime
    {
        return $this->deletedAt;
    }

    public function setCode(int $code): void 
    {
        $this->code = $code;
    }
    
    public function setName(string $name): void 
    {
        $this->name = $name;
    }
    
    public function setValue(float $value): void 
    {
        $this->value = $value;
    }
    
    public function setUpdatedAt(DateTime $updatedAt): void 
    {
        $this->updatedAt = $updatedAt;
    }

    public function setDeletedAt(DateTime $deletedAt): void 
    {
        $this->deletedAt = $deletedAt;
    }
}