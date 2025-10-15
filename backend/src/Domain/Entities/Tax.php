<?php

namespace App\Domain\Entities;

readonly class Tax
{
	public function __construct(
		private int $id,
		private int $typeProductId,
		private float $value
	) {
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getTypeProductId(): int
	{
		return $this->typeProductId;
	}

	public function getValue(): float
	{
		return $this->value;
	}
}
