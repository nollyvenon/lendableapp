<?php
declare(strict_types=1);

namespace Tests\Unit\Service;

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Service\ArrayFeeBreakpointsProvider;
use Lendable\Interview\Interpolation\Service\FeeCalculator;
use Lendable\Interview\Interpolation\Service\LinearInterpolation;
use Lendable\Interview\Interpolation\Service\FeeRounder;
use Lendable\Interview\Interpolation\ValueObject\LoanAmount;
use Lendable\Interview\Interpolation\ValueObject\Term;
use PHPUnit\Framework\TestCase;

class FeeCalculatorTest extends TestCase
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
    public function exactBreakpointData(): array
    {
        return [
            [1000, 12, 50.0],
            [2000, 12, 90.0],
            [20000, 24, 800.0],
        ];
    }

    /**
     * @return array<int, array{float, int, float}> Array of [amount, term, expectedFee]
     */
    public function interpolationData(): array
    {
        return [
            [1500, 12, 70.0],
            [2750, 24, 115.0],
            [3500, 12, 105.0],
        ];
    }

    /**
     * @return array<int, array{float, int, float}> Array of [amount, term, expectedFee]
     */
    public function roundingData(): array
    {
        return [
            [1004.23, 12, 50.77],
            [1999.99, 24, 100.01],
            [19250, 12, 385.0],
        ];
    }

    /**
     * @return array<int, array{int, float, class-string<\Throwable>}> Array of [term, amount, exception]
     */
    public function invalidInputData(): array
    {
        return [
            [6, 1000.0, \InvalidArgumentException::class],
            [12, 500.0, \InvalidArgumentException::class],
            [24, 20001.0, \InvalidArgumentException::class],
        ];
    }

    /**
     * @dataProvider exactBreakpointData
     */
    public function testExactBreakpoints(float $amount, int $term, float $expectedFee): void
    {
        $application = new LoanApplication(new Term($term), new LoanAmount($amount));
        $this->assertSame($expectedFee, $this->calculator->calculate($application));
    }

    /**
     * @dataProvider interpolationData
     */
    public function testInterpolation(float $amount, int $term, float $expectedFee): void
    {
        $application = new LoanApplication(new Term($term), new LoanAmount($amount));
        $this->assertSame($expectedFee, $this->calculator->calculate($application));
    }

    /**
     * @dataProvider roundingData
     */
    public function testRounding(float $amount, int $term, float $expectedFee): void
    {
        $application = new LoanApplication(new Term($term), new LoanAmount($amount));
        $fee = $this->calculator->calculate($application);
        $this->assertSame($expectedFee, $fee);
        $this->assertEquals(0, fmod($amount + $fee, 5), "Total not multiple of 5");
    }

    /**
     * @dataProvider invalidInputData
     */
    public function testInvalidInputs(int $term, float $amount, string $exception): void
    {
        $this->expectException($exception);
        new LoanApplication(new Term($term), new LoanAmount($amount));
    }

    public function testExampleFromProblemStatement(): void
    {
        $application = new LoanApplication(new Term(12), new LoanAmount(19250.0));
        $fee = $this->calculator->calculate($application);
        $this->assertEquals(385.0, $fee); // Now passes
    }
}