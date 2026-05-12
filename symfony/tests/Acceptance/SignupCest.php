<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use Codeception\Attribute\After;
use Codeception\Attribute\Before;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Depends;
use Codeception\Attribute\Env;
use Codeception\Attribute\Examples;
use Codeception\Attribute\Group;
use Codeception\Attribute\Skip;
use Codeception\Scenario;

use App\Tests\Support\AcceptanceTester;

/*
 * Following this approach will allow you to keep your tests clean, readable, stable and make them easy to maintain.
 * 
 * 1. Group common actions together and move them to an Actor class or StepObjects. 
 * 2. Move CSS and XPath locators into PageObjects.
 * 3. Write your custom actions and assertions in Helpers. 
 * 4. Scenario-driven tests should not contain anything more complex than $I->doSomething commands. 
 * 
 */
final class SignupCest
{
    public function _before(AcceptanceTester $I, \Codeception\Scenario $scenario): void
    {
        $modules = array_map('get_class', $scenario->current('modules'));

        // Code here will be executed before each test function.
        $I->amOnPage('/signup');
        $I->seeLink('Login');

        /*-----------------
         * Action for URLs
         */
        $I->seeInCurrentUrl('/signup');
        $I->seeCurrentUrlEquals('/signup');
        $I->seeCurrentUrlMatches('~^/s(\w+)p~');
        
        $slug = $I->grabFromCurrentUrl('~^/(\w+)~');
        codecept_debug($slug);

        /*-------------------------------------
         * Actions for checking the page title
         */
        $I->seeInTitle('Sign Up');
        $I->dontSeeInTitle('Register');

        /*--------------------
         * Action for cookies
         */
        $I->setCookie('auth', '123345');
        
        $cookie = $I->grabCookie('auth');
        codecept_debug($cookie);

        $I->seeCookie('auth');

        /*------
         * Wait
         * 
         * While testing web application, you may need to wait for JavaScript events to occur. Due to its asynchronous nature, 
         * complex JavaScript interactions are hard to test. That’s why you may need to use waiters, actions with wait prefix. 
         * They can be used to specify what event you expect to occur on a page, before continuing the test.
         */
        if (in_array('Codeception\Module\WebDriver', $modules)) {
            $I->waitForElement('#agree-terms', 5);
            $I->waitForElementVisible('#agree-terms', 5);
            $I->waitForText('I agree to the terms and conditions', 5);
        }
    }

    // All `public` methods will be executed as tests.

    // Set a group for this test
    // You can run tests from this group using `php vendor/bin/codecept run acceptance --group user`

    #[Group('user', 'account')] 
    public function signUpSuccessfully(AcceptanceTester $I, \Codeception\Scenario $scenario): void
    {
        $modules = array_map('get_class', $scenario->current('modules'));

        // We can use the label, input name or id to match the `username` field

        // To match fields by their labels, you should write a `for` attribute in the label tag.

        /*------------
         * Forms
         * 
         * To fill in all of the fields at once and send the form without clicking a ‘Submit’ button, 
         * we can use the `submitForm` method:
         * 
         *   $I->submitForm(
         *       '#signup-form', 
         *       [
         *           'user' => [
         *               'username' => 'dominic@example.com',
         *               'password' => 'password123',
         *               'gender' => 'male'
         *           ]
         *       ],
         *       'signup' // button values
         *   );
         * 
         * The submitForm is not emulating a user’s actions.
        */
        $I->fillField('username', 'dominic@example.com');
        $I->seeInField('username', 'dominic@example.com');

        $username = $I->grabValueFrom('#username');
        codecept_debug($username);

        // PasswordArgument: to fill in sensitive data (like passwords) and hide it in logs
        $I->fillField('password', new \Codeception\Step\Argument\PasswordArgument('password123')); 

        // $password = $I->grabValueFrom('#password');
        // codecept_debug($password);

        $I->selectOption('gender', 'male');

        $I->checkOption('agree-terms');
        $I->seeCheckboxIsChecked('#agree-terms');

        /*----------------------
         * Interactive pause
         *
         * Interactive pause is launched only when --debug option is enabled
         * > php vendor/bin/codecept run --debug
         *
         */  

        // $I->pause();

        // To inspect local variables pass them into interactive shell using an array:

        // $I->pause(['user' => $user])
        // codecept_pause(['user' => $user]);

        /*------- 
         * Click
         * 
         * Alternative ways to click the "Sign Up" button:
         * 
         * // CSS selector applied
         *   $I->click('#signup');
         * 
         * // XPath
         *   $I->click('//button[@id="signup"]');
         * 
         * // Using context as second argument
         *   $I->click('Sign Up', '.container');
         * 
         * // By specifying locator type
         *   $I->click(['id' => 'signup']);
         * 
         * // Locator helper method
         *   $I->click('Sign Up' , \Codeception\Util\Locator::isID('signup'));
         */
        $I->amGoingTo('submit user form with valid values');
        $I->click('Sign Up');
        $I->expect('the form is submitted');
       
        /*-----------------------------
         * A/B Testing: tryToX methods
         *
         * We may try to hit the 'Close' button but if this action fails, we just continue the test
         * 
         *   $I->tryToClick('Close');
         *        
         *   if ($I->tryToSeeElement('Close')) {
         *     $I->click('Close');
         *   }
         */

        /*------------
         * Assertions
         * 
         * check that 'Thank you for Signing Up!' is inside an element with 'thank-you-message' id.
         *   $I->see('Thank you for Signing Up!', '#thank-you-message');
         */
        if (in_array('Codeception\Module\WebDriver', $modules)) {
            $I->waitForText('Thank you for Signing Up!', 5);

            // Wait for '#thank-you-message' and act
            $I->performOn('#thank-you-message', function(\Codeception\Module\WebDriver $I) {
                $I->see('Thank you for Signing Up!');
            });
        }
        $I->see('Thank you for Signing Up!');

        // We check this message is *not* on the page.
        $I->dontSee('Form is filled incorrectly');

        // You can check that a specific HTML element exists (or doesn’t) on a page
        $I->seeElement('.notice');
        $I->dontSeeElement('.error');

        /*------------------------
         * Conditional assertions
         * 
         * Usually, as soon as any assertion fails, further assertions of this test will be skipped. 
         * Sometimes you don’t want this - maybe you have a long-running test and you want it to run 
         * to the end. In this case, you can use conditional assertions.
         * 
         * Each see method has a corresponding canSee method, and dontSee has a cantSee method.
         * 
         * Each failed assertion will be shown in the test results, but it won’t stop the test.
         */
        $I->canSeeElement('.notice');
        $I->cantSeeElement('.error');
    }

    // If you want to execute the same test scenario with different data
    #[Examples(name: 'dominic@example.com', password: 'password123')]
    #[Examples(name: 'peter@example.com',   password: 'password456')]
    public function signUpSuccessfullyWithPageObject(AcceptanceTester $I, \App\Tests\Support\Page\Acceptance\Signup $signupPage, \Codeception\Example $example): void
    {
        $I->amOnPage('/signup');
        $signupPage->signUp($example['name'], $example['password'], 'male', true);
        $I->see('Thank you for Signing Up!');
    }

    // You can also use `DataProvider` to provide data for the test method. The method should return an array of arrays with the test data.
    #[DataProvider('userProvider')]
    public function signUpSuccessfullyWithStepObject(AcceptanceTester $I, \App\Tests\Support\Step\Acceptance\Admin $adminSteps, \Codeception\Example $example): void
    {
        $I->amOnPage('/signup');
        $adminSteps->signUpAsAdmin();
        $I->see('Thank you for Signing Up!');
    }

    // With the #[Depends] attribute, you can specify a test that should be passed before the current one
    #[Depends('signUpSuccessfully')]
    public function listPrice(AcceptanceTester $I): void
    {
    }

    // This test will be executed in 'firefox' and 'chrome' environments
    #[Env('chrome', 'firefox')]
    public function showImage(AcceptanceTester $I): void
    {
    }

    public function listTestMetadata(Scenario $scenario)
    {
        // list all metadata variables
        codecept_debug($scenario->current());
    }

    // You can explain the reason to skip test in attribute
    #[Skip('this one is not needed anymore')]
    public function notAnImportantTest(AcceptanceTester $I, Scenario $scenario): void
    {
        // If you need to skip a test on a condition, inject Codeception\Scenario into the test
        $shouldNotBeExecuted = true;

        if ($shouldNotBeExecuted) {
            $scenario->skip('This test is skipped on this condition');
        }
    }

    #[Before('signupSuccessfully', 'signUpSuccessfullyWithPageObject', 'signUpSuccessfullyWithStepObject')]
    private function checkUserNotExist() : void 
    {
    }

    #[After('signupSuccessfully', 'signUpSuccessfullyWithPageObject', 'signUpSuccessfullyWithStepObject')]
    private function checkUserExist() : void 
    {
    }

    private function userProvider() : array
    {
        return [
            ["name" => "john@example.com", "password" => "password123"],
            ["name" => "david@example.com",   "password" => "password456"]
        ];
    }

    public function _passed(AcceptanceTester $I)
    {
        // will be executed when test is successful
    }

    public function _failed(AcceptanceTester $I)
    {
        // will be executed on test failure
    }
}

/*-------
 * Other
 *
 * https://codeception.com/docs/AcceptanceTests > Multi Session Testing
 * 
 */