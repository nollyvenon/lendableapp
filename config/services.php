<?php

use Lendable\Interview\Interpolation\Factory\LoanApplicationFactory;

$standardFactory = new LoanApplicationFactory();

// Valid personal loan
$personalApp = $standardFactory->create(12, 1500.0);

// Invalid business loan (but valid personal)
try {
    $standardFactory->create(6, 3000.0); // Term 6 not allowed for personal
} catch (\InvalidArgumentException $e) {
    echo $e->getMessage(); // "Invalid term"
}