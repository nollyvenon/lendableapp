<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Lendable\Interview\Interpolation\Factory\LoanApplicationFactory;
use Lendable\Interview\Interpolation\Factory\BusinessLoanApplicationFactory;
use Lendable\Interview\Interpolation\Service\ArrayFeeBreakpointsProvider;
use Lendable\Interview\Interpolation\Service\FeeCalculator;
use Lendable\Interview\Interpolation\Service\FeeRounder;
use Lendable\Interview\Interpolation\Service\LinearInterpolation;

// Factory selection
$loanType = strtolower(readline('Loan type (personal/business): '));

// Initialize calculator with dependencies
$calculator = new FeeCalculator(
    new ArrayFeeBreakpointsProvider(),
    new LinearInterpolation(),
    new FeeRounder()
);
$factory = match($loanType) {
    'business' => new BusinessLoanApplicationFactory(),
    default => new LoanApplicationFactory() // This was missing
};

try {
    $amount = (float)readline('Amount: ');
    $term = (int)readline('Term: ');

    $application = $factory->create($term, $amount);
    // Calculate fee
    $fee = $calculator->calculate($application);

    // Format output
    echo "\nCalculation Result:\n";
    echo str_repeat('-', 40) . "\n";
    printf("Loan Amount: £%s\n", number_format($amount, 2));
    printf("Term: %d months\n", $term);
    printf("Fee: £%s\n", number_format($fee, 2));
    printf("Total Repayable: £%s\n", number_format($amount + $fee, 2));

    // Verify 5-divisibility rule
    $total = $amount + $fee;
    if (fmod($total, 5) !== 0.0) {
        throw new RuntimeException('Fee rounding validation failed');
    }
} catch (\Throwable $e) {
    echo 'Error: ' . $e->getMessage();
}