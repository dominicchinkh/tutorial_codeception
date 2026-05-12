<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use App\Tests\Support\AcceptanceTester;
use Codeception\Attribute\Given;
use Codeception\Attribute\When;
use Codeception\Attribute\Then;

class SignupContext
{
    private AcceptanceTester $I;

    public function __construct(AcceptanceTester $I)
    {
        $this->I = $I;
    }

    #[Given('I am on the signup page')]
    public function iAmOnTheSignupPage(): void
    {
        $this->I->amOnPage('/signup');
    }

    #[When('/^I fill in the form with ([a-zA-Z0-9.@]+) and (\S+)$/')]
    public function iFillInTheFormWith(string $email, string $password): void
    {
        $this->I->fillField('username', $email);
        $this->I->fillField('password', $password);
    }

    #[When('I submit the form')]
    public function iSubmitTheForm(): void
    {
        $this->I->click('Sign Up');
    }

    #[Then('I should see a success message')]
    public function iShouldSeeASuccessMessage(): void
    {
        $this->I->see('Thank you for Signing Up!');
    }
}
