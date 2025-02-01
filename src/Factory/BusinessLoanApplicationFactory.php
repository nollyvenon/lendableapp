<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Factory;

use Lendable\Interview\Interpolation\Model\BusinessLoanApplication;
use Lendable\Interview\Interpolation\ValueObject\BusinessTerm;
use Lendable\Interview\Interpolation\ValueObject\BusinessLoanAmount;

final class BusinessLoanApplicationFactory implements LoanApplicationFactoryInterface
{
    public function create(int $term, float $amount): BusinessLoanApplication
    {
        return new BusinessLoanApplication(
            new BusinessTerm($term),
            new BusinessLoanAmount($amount)
        );
    }
}
