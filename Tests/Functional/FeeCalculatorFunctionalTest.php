<?php

declare(strict_types=1);

namespace Functional;

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Service\ArrayFeeBreakpointsProvider;
use Lendable\Interview\Interpolation\Service\FeeCalculator;
use Lendable\Interview\Interpolation\Service\FeeRounder;
use Lendable\Interview\Interpolation\Service\LinearInterpolation;
use Lendable\Interview\Interpolation\ValueObject\LoanAmount;
use Lendable\Interview\Interpolation\ValueObject\Term;
use PHPUnit\Framework\TestCase;

class FeeCalculatorFunctionalTest extends TestCase
{
    private FeeCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new FeeCalculator(
            new ArrayFeeBreakpointsProvider(),
            new LinearInterpolation(),
            new FeeRounder()
        );
    }

    /**
     * @return array<int, array{float, int, float}> Array of [amount, term, expectedFee]
     */
    public function feeCalculationData(): array
    {
        return [
            // Exact breakpoints
            [1000, 12, 50.0],
            [2000, 12, 90.0],
            [20000, 24, 800.0],

            // Linear interpolation cases
            [1500, 12, 70.0],    // Between 1000(50) and 2000(90)
            [2750, 24, 115.0],   // Example from spec
            [11500, 24, 460.0],  // Example from spec
            [19250, 12, 385.0],  // Example from spec

            // Rounding required cases
            [1004.23, 12, 50.77],  // 1004.23 + 50.77 = 1055 (multiple of 5)
            [19995.50, 24, 804.50], // 19995.50 + 804.50 = 20800
        ];
    }

    /**
     * @dataProvider feeCalculationData
     */
    public function testFeeCalculation(float $amount, int $term, float $expectedFee): void
    {
        $application = new LoanApplication(
            new Term($term),
            new LoanAmount($amount)
        );

        $fee = $this->calculator->calculate($application);

        $this->assertSame($expectedFee, $fee);
        $this->assertValidTotal($amount, $fee);
    }

    private function assertValidTotal(float $amount, float $fee): void
    {
        $total = $amount + $fee;
        $this->assertEquals(0, fmod($total, 5), "Total amount $total is not multiple of 5");
    }

    public function testAllBreakpoints(): void
    {
        $terms = [12, 24];

        foreach ($terms as $term) {
            $provider = new ArrayFeeBreakpointsProvider();
            $breakpoints = $provider->forTerm($term);

            foreach ($breakpoints as $amount => $expectedFee) {
                $application = new LoanApplication(
                    new Term($term),
                    new LoanAmount((float)$amount)
                );

                $fee = $this->calculator->calculate($application);
                $this->assertSame((float)$expectedFee, $fee);
                $this->assertValidTotal((float)$amount, $fee);
            }
        }
    }
}
