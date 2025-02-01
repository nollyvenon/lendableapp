<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\ValueObject;

class LoanAmount
{
    public function __construct(private readonly float $value)
    {
        if ($value < 1000 || $value > 20000) {
            throw new \InvalidArgumentException('Invalid loan amount');
        }
    }

    public function value(): float
    {
        return $this->value;
    }
}
