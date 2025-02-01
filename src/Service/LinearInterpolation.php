<?php
declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service;

final class LinearInterpolation
{
    /**
     * @param array<int, float> $breakpoints [amount => fee]
     */
    public function interpolate(float $amount, array $breakpoints): float
    {
        ksort($breakpoints);

        $lowerAmount = $lowerFee = $upperAmount = $upperFee = null;
        $lastAmount = null;

        foreach ($breakpoints as $currentAmount => $currentFee) {
            if ($currentAmount <= $amount) {
                $lowerAmount = $currentAmount;
                $lowerFee = $currentFee;
            } else {
                $upperAmount = $currentAmount;
                $upperFee = $currentFee;
                break;
            }
            $lastAmount = $currentAmount;
        }

        // Handle exact match or upper bound
        if ($upperAmount === null) {
            return $lowerFee ?? throw new \RuntimeException('No breakpoints found');
        }

        // Linear calculation
        return $lowerFee +
            (($amount - $lowerAmount) / ($upperAmount - $lowerAmount)) *
            ($upperFee - $lowerFee);
    }
}