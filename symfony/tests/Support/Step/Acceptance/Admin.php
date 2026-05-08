<?php

declare(strict_types=1);

namespace App\Tests\Support\Step\Acceptance;

class Admin extends \App\Tests\Support\AcceptanceTester
{
    public function signUpAsAdmin()
    {
        $I = $this;

        $I->fillField('username', 'admin@example.com');
        $I->fillField('password', new \Codeception\Step\Argument\PasswordArgument('password123')); 
        $I->selectOption('gender', 'male');
        $I->checkOption('agree-terms');

        $I->click('Sign Up');
    }
}
