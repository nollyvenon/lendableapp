<?php
declare(strict_types=1);

namespace Tests\Unit\Factory;

use Lendable\Interview\Interpolation\Factory\LoanApplicationFactory;
use Lendable\Interview\Interpolation\Factory\BusinessLoanApplicationFactory;
use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Model\BusinessLoanApplication;
use Lendable\Interview\Interpolation\ValueObject\Term;
use Lendable\Interview\Interpolation\ValueObject\LoanAmount;
use Lendable\Interview\Interpolation\ValueObject\BusinessTerm;
use Lendable\Interview\Interpolation\ValueObject\BusinessLoanAmount;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class LoanFactoryTest extends TestCase
{
    /**
     * @return array<int, array{int, float}> Array of [term, amount]
     */
    public function validPersonalLoanProvider(): array
    {
        return [
            [12, 1000.0],
            [24, 20000.0],
        ];
    }

    /**
     * @return array<int, array{int, float, class-string<\Throwable>}> Array of [term, amount, exception]
     */
    public function invalidPersonalLoanProvider(): array
    {
        return [
            [6, 1000.0, InvalidArgumentException::class],
            [12, 500.0, InvalidArgumentException::class],
            [24, 20001.0, InvalidArgumentException::class],
        ];
    }

    /**
     * @return array<int, array{int, float}> Array of [term, amount]
     */
    public function validBusinessLoanProvider(): array
    {
        return [
            [6, 5000.0],
            [24, 100000.0],
        ];
    }

    /**
     * @return array<int, array{int, float, class-string<\Throwable>}> Array of [term, amount, exception]
     */
    public function invalidBusinessLoanProvider(): array
    {
        return [
            [3, 5000.0, InvalidArgumentException::class],
            [6, 4999.99, InvalidArgumentException::class],
            [24, 100000.01, InvalidArgumentException::class],
        ];
    }

    /**
     * @dataProvider validPersonalLoanProvider
     */
    public function testValidPersonalLoanCreation(int $term, float $amount): void
    {
        $factory = new LoanApplicationFactory();
        $application = $factory->create($term, $amount);

        $this->assertInstanceOf(LoanApplication::class, $application);
        $this->assertInstanceOf(Term::class, $application->term());
        $this->assertInstanceOf(LoanAmount::class, $application->amount());
    }

    /**
     * @dataProvider invalidPersonalLoanProvider
     */
    public function testInvalidPersonalLoans(int $term, float $amount, string $exception): void
    {
        $this->expectException($exception);

        $factory = new LoanApplicationFactory();
        $factory->create($term, $amount);
    }

    /**
     * @dataProvider validBusinessLoanProvider
     */
    public function testValidBusinessLoanCreation(int $term, float $amount): void
    {
        $factory = new BusinessLoanApplicationFactory();
        $application = $factory->create($term, $amount);

        $this->assertInstanceOf(BusinessLoanApplication::class, $application);
        $this->assertInstanceOf(BusinessTerm::class, $application->term());
        $this->assertInstanceOf(BusinessLoanAmount::class, $application->amount());
    }

    /**
     * @dataProvider invalidBusinessLoanProvider
     */
    public function testInvalidBusinessLoans(int $term, float $amount, string $exception): void
    {
        $this->expectException($exception);

        $factory = new BusinessLoanApplicationFactory();
        $factory->create($term, $amount);
    }

    public function testObjectTypeSafety(): void
    {
        $personalFactory = new LoanApplicationFactory();
        $businessFactory = new BusinessLoanApplicationFactory();

        $personalApp = $personalFactory->create(12, 1000.0);
        $businessApp = $businessFactory->create(6, 5000.0);

        $this->assertNotSame(get_class($personalApp), get_class($businessApp));
        $this->assertNotSame(get_class($personalApp->term()), get_class($businessApp->term()));
    }
}