# Lendable Interview Test - Fee Calculator

A PHP-based fee calculator that determines loan fees based on amount, term, and predefined fee structures, following OOP principles and SOLID design.

## Features
- **Fee Calculation**: Compute fees for loan amounts between £1,000-£20,000
- **Term Support**: 12 or 24-month terms
- **Linear Interpolation**: Calculate fees between breakpoints
- **Rounding**: Ensure (amount + fee) is multiple of 5
- **Validation**: Strict input validation using value objects
- **Testing**: Full test suite with PHPUnit

## Requirements
- PHP 8.1+
- Composer

## Installation
```bash
git clone [your-repo-url]
cd lendable_test
composer install
```

## Usage
### Command Line Interface
```
php index.php
```

#### Example:
```
Enter loan amount (£1,000-£20,000): 11500
Enter term (12 or 24 months): 24

Calculation Result:
----------------------------------------
Loan Amount: £11,500.00
Term: 24 months
Fee: £460.00
Total Repayable: £11,960.00
```

### Programmatic Usage
```
use Lendable\Interview\Interpolation\Model\LoanApplication;
use Lendable\Interview\Interpolation\Service\FeeCalculator;

$calculator = new FeeCalculator(/* dependencies */);
$application = new LoanApplication(new Term(24), new LoanAmount(2750.0));
$fee = $calculator->calculate($application); // Returns 115.0
```

### Testing
```
# Run all tests
composer test

# Run specific test group
./vendor/bin/phpunit tests/Unit/Service/FeeCalculatorTest.php

# Check coding standards
composer cs-check

# Fix coding standards
composer cs-fix

# Static analysis
composer phpstan
```

### Directory Structure
```
src/
├── Model/               # Domain models
├── Service/             # Business logic
├── ValueObject/         # Validated value objects
tests/
├── Unit/                # Unit tests
├── Functional/          # Functional tests
index.php                # CLI interface
mod_index.php            # CLI interface
composer.json            # Dependency management
```

## Interface Extension
### Enhanced Features
- **Factory Pattern Implementation**
    - `LoanApplicationFactory`: Standard personal loans (£1,000-£20,000, 12/24mo)
    - `BusinessLoanApplicationFactory`: Business loans (£5,000-£100,000, 6/12/24mo)
- **Extensible Architecture**: Easily add new loan types via factories
- **Domain-Specific Validation**: Different rules per loan type

## Factory Usage
### Standard Personal Loans
```php
use Lendable\Interview\Interpolation\Factory\LoanApplicationFactory;

$factory = new LoanApplicationFactory();
$application = $factory->create(12, 1500.0); // Term, Amount

```

### Factory Comparison
```
Feature	Standard    |     Factory	     |       Business Factory
|-------------------|------------------------|------------------------
Valid Terms	       12, 24 months	          6, 12, 24 months
Amount Range	    £1,000 - £20,000	        £5,000 - £100,000
Validation Rules	Consumer credit rules	Commercial lending regulations
Typical Use Case	Personal loans	        Business financing
Value Objects Used	Term, LoanAmount	    BusinessTerm, BusinessLoanAmount
```

### Business Loans
```php
use Lendable\Interview\Interpolation\Factory\BusinessLoanApplicationFactory;

$factory = new BusinessLoanApplicationFactory();
$application = $factory->create(6, 25000.0); // 6-month term allowed
```

Extension Guide

To add a new loan type:

    1. Create new value objects extending base types

    2. Implement LoanApplicationInterface

    3. Create factory implementing LoanApplicationFactoryInterface

    4. Register factory in dependency container

```php
class CustomLoanApplicationFactory implements LoanApplicationFactoryInterface {
    // Custom validation and object creation
}
```

## Key Architectural Principles
-  Factory Method Pattern: Encapsulate object creation

-  Open/Closed Principle: Extend via new factories, not modification

-  Liskov Substitution: All factories implement LoanApplicationFactoryInterface

-  Domain-Driven Design: Separate value objects for different loan types

## Example Test Cases
```php
// Test business factory
public function testBusinessLoanCreation(): void
{
    $factory = new BusinessLoanApplicationFactory();
    $app = $factory->create(6, 5000.0);
    $this->assertInstanceOf(BusinessLoanApplication::class, $app);
}

// Test standard factory constraints
public function testPersonalLoanValidation(): void
{
    $this->expectException(InvalidArgumentException::class);
    $factory = new LoanApplicationFactory();
    $factory->create(6, 500.0); // Invalid term and amount
}
```

### Technical Details

    PHP Version: 8.1+

    Dependencies: None (production)

    Dev Dependencies:

        PHPUnit 9.5+

        PHPStan (Level 6)

        PHP-CS-Fixer

### Fee Structure Examples
```
  Loan Amount	Term (months)	Fee
  £1,000	        12	£50
  £2,750	        24	£115
  £11,500	        24	£460
  £19,250	        12	£385
  ```

  Key Principles

    Object-Oriented Programming
    SOLID design principles
    Value Objects for validation
    Dependency Injection
    PSR-12 coding standards
    Strict type declarations#   l e n d a b l e a p p  
 