<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service;

use Lendable\Interview\Interpolation\Model\LoanApplicationInterface;

interface FeeCalculatorInterface
{
    public function calculate(LoanApplicationInterface $application): float;
}
