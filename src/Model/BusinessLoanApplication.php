<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model;

use Lendable\Interview\Interpolation\ValueObject\BusinessTerm;
use Lendable\Interview\Interpolation\ValueObject\BusinessLoanAmount;

final class BusinessLoanApplication implements LoanApplicationInterface
{
    public function __construct(
        private BusinessTerm $term,
        private BusinessLoanAmount $amount
    ) {
    }

    public function term(): BusinessTerm
    {
        return $this->term;
    }

    public function amount(): BusinessLoanAmount  // Use base return type
    {
        return $this->amount;
    }
}
