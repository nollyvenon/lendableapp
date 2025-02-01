<?php

declare(strict_types=1);

namespace Tests\Unit\Factory;

use Lendable\Interview\Interpolation\Factory\LoanApplicationFactory;
use Lendable\Interview\Interpolation\Factory\LoanApplicationFactoryInterface;
use PHPUnit\Framework\TestCase;

class LoanApplicationFactoryTest extends TestCase
{
    public function testCreatesValidApplication(): void
    {
        $factory = new LoanApplicationFactory();
        $application = $factory->create(12, 1500.0);

        $this->assertSame(12, $application->term()->value());
        $this->assertSame(1500.0, $application->amount()->value());
        $this->assertInstanceOf(LoanApplicationFactoryInterface::class, $factory);
    }
}
