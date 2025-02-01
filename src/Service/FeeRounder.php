<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service;

final class FeeRounder
{
    public function roundToFiveMultiples(float $amount, float $fee): float
    {
        $total = $amount + $fee;
        $remainder = fmod($total, 5);

        if ($remainder !== 0.0) {
            $fee += 5 - $remainder;
        }

        return round($fee, 2);
    }
}
