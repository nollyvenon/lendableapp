<?php
use Lendable\Interview\Interpolation\Factory\BusinessLoanApplicationFactory;

$businessFactory = new BusinessLoanApplicationFactory();

// Valid business loan
$businessApp = $businessFactory->create(6, 10000.0);

// Invalid personal loan attempt
try {
    $businessFactory->create(12, 3000.0); // Amount too low for business
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage(); // "Business loans: £5,000-£100,000"
}