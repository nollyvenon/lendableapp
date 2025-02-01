<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service;

use Lendable\Interview\Interpolation\Model\LoanApplicationInterface;

final class FeeCalculator implements FeeCalculatorInterface
{
    public function __construct(
        private FeeBreakpointsProviderInterface $breakpointsProvider,
        private LinearInterpolation $interpolation,
        private FeeRounder $rounder
    ) {
    }

    public function calculate(LoanApplicationInterface $application): float
    {
        $term = $application->term()->value();
        $amount = $application->amount()->value();

        $breakpoints = $this->breakpointsProvider->forTerm($term);
        $fee = $this->interpolation->interpolate($amount, $breakpoints);

        return $this->rounder->roundToFiveMultiples($amount, $fee);
    }
}
