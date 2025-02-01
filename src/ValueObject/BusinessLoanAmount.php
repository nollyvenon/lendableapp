<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\ValueObject;

final class BusinessLoanAmount extends LoanAmount
{
    public function __construct(float $value)
    {
        if ($value < 5000 || $value > 100000) {
            throw new \InvalidArgumentException('Business loans: £5,000-£100,000');
        }

        parent::__construct($value);
    }
}
