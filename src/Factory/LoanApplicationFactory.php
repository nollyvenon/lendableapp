<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Factory;

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Model\LoanApplicationInterface;
use Lendable\Interview\Interpolation\ValueObject\Term;
use Lendable\Interview\Interpolation\ValueObject\LoanAmount;

final class LoanApplicationFactory implements LoanApplicationFactoryInterface
{
    public function create(int $term, float $amount): LoanApplicationInterface
    {
        return new LoanApplication(
            new Term($term),
            new LoanAmount($amount)
        );
    }
}
