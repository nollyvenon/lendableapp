<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
// Create factory
use Lendable\Interview\Interpolation\Factory\LoanApplicationFactory;

$applicationFactory = new LoanApplicationFactory();

// Create application through factory
try {
    $termInput = 12;
    $amountInput = 19000;
    $application = $applicationFactory->create(
        (int)$termInput,
        (float)$amountInput
    );
    print_r($application);

} catch (\InvalidArgumentException $e) {
    // Handle validation errors
}