<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObject;

use Lendable\Interview\Interpolation\ValueObject\Term;
use PHPUnit\Framework\TestCase;

class TermTest extends TestCase
{
    /**
     * @return array<int, array{int}> Array of [valid term]
     */
    public function validTerms(): array
    {
        return [[12], [24]];
    }

    /**
     * @return array<int, array{int}> Array of [invalid term]
     */
    public function invalidTerms(): array
    {
        return [[11], [25], [0], [-12]];
    }

    /**
     * @dataProvider validTerms
     */
    public function testValidTerms(int $value): void
    {
        $term = new Term($value);
        $this->assertSame($value, $term->value());
    }

    /**
     * @dataProvider invalidTerms
     */
    public function testInvalidTerms(int $value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Term($value);
    }
}
