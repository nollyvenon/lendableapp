<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Service\ArrayFeeBreakpointsProvider;
use Lendable\Interview\Interpolation\Service\FeeCalculator;
use Lendable\Interview\Interpolation\Service\LinearInterpolation;
use Lendable\Interview\Interpolation\Service\FeeRounder;
use Lendable\Interview\Interpolation\ValueObject\Term;
use Lendable\Interview\Interpolation\ValueObject\LoanAmount;

// Initialize calculator with dependencies
$calculator = new FeeCalculator(
    new ArrayFeeBreakpointsProvider(),
    new LinearInterpolation(),
    new FeeRounder()
);

echo "Lendable Fee Calculator\n";
echo "=======================\n";

// Get user input
try {
    $amount = (float)readline('Enter loan amount (£1,000-£20,000): ');
    $term = (int)readline('Enter term (12 or 24 months): ');

    // Create loan application
    $application = new LoanApplication(
        new Term($term),
        new LoanAmount($amount)
    );

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

} catch (\InvalidArgumentException $e) {
    echo "\nError: " . $e->getMessage() . "\n";
    exit(1);
} catch (\Exception $e) {
    echo "\nAn error occurred: " . $e->getMessage() . "\n";
    exit(1);
}