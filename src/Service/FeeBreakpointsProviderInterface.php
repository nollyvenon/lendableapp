<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Service;

interface FeeBreakpointsProviderInterface
{
    /**
     * @return array<int, float>
     */
    public function forTerm(int $term): array;
}
