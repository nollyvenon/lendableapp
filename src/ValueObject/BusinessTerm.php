<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\ValueObject;

final class BusinessTerm extends Term
{
    protected const VALID_TERMS = [6, 12, 24]; // Extended terms
}
