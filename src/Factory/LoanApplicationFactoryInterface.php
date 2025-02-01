<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Factory;

use Lendable\Interview\Interpolation\Model\LoanApplicationInterface;

interface LoanApplicationFactoryInterface
{
    public function create(int $term, float $amount): LoanApplicationInterface;
}
