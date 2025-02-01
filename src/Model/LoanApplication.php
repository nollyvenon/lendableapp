<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model;

use Lendable\Interview\Interpolation\ValueObject\Term;
use Lendable\Interview\Interpolation\ValueObject\LoanAmount;

final class LoanApplication implements LoanApplicationInterface
{
    public function __construct(
        private Term $term,
        private LoanAmount $amount
    ) {
    }

    public function term(): Term
    {
        return $this->term;
    }

    public function amount(): LoanAmount
    {
        return $this->amount;
    }
}
