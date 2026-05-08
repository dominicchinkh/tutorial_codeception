<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Support\FunctionalTester;
use Codeception\Attribute\Prepare;

// Functional tests are almost the same as acceptance tests, with one major difference: Functional tests 
// don’t require a web server.

final class SignupCest
{
    public function _before(FunctionalTester $I): void
    {
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
    }

    // All `public` methods will be executed as tests.
    #[Prepare('setupUser')]
    public function signUpSuccessfully(FunctionalTester $I): void
    {
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

    protected function setupUser(\Codeception\Module\Doctrine $doctrine, \Codeception\Module\Symfony $symfony)
    {
        // Option 1: Use the Codeception Doctrine module methods directly
        $doctrine->haveInRepository(\App\Entity\User::class, [
            'username' => 'dominic@example.com', 
            'password' => password_hash('password123', PASSWORD_ARGON2ID), 
            'hasAgreeTerms' => true]
        );
        
        // Option 2: Get the raw Entity Manager from Doctrine module
        /** @var \Doctrine\ORM\EntityManagerInterface $em */
        $em = $doctrine->_getEntityManager();

        // Option 3: Get the doctrine service directly from the Symfony module
        /** @var \Doctrine\Persistence\ManagerRegistry $doctrineRegistry */
        $doctrineRegistry = $symfony->grabService('doctrine');
    }
}
