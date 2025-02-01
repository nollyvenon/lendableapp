<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\ValueObject;

final class Fee
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Fee cannot be negative.');
        }

        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }
}
