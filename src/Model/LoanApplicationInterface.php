<?php

declare(strict_types=1);

namespace Lendable\Interview\Interpolation\Model;

use Lendable\Interview\Interpolation\ValueObject\Term;
use Lendable\Interview\Interpolation\ValueObject\LoanAmount;

interface LoanApplicationInterface
{
    public function term(): Term;
    public function amount(): LoanAmount;
}
