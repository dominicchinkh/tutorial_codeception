<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use App\Tests\Support\AcceptanceTester;

final class SignupCest
{
    public function _before(AcceptanceTester $I): void
    {
        // Code here will be executed before each test function.
    }

    // All `public` methods will be executed as tests.
    public function tryToTest(AcceptanceTester $I): void
    {
        // Write your test content here.

        $I->amOnPage('/signup');
        $I->fillField('username', 'dominic@example.com');
        $I->fillField('password', 'password123');
        $I->click('Sign Up');
        $I->see('Thank you for Signing Up!');
    }
}
