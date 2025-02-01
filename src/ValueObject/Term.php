<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\ValueObject;

class Term // Removed 'final' keyword
{
    protected const VALID_TERMS = [12, 24];

    public function __construct(private readonly int $value)
    {
        if (!in_array($this->value, static::VALID_TERMS, true)) {
            throw new \InvalidArgumentException('Invalid term');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
