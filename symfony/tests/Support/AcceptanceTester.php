<?php

declare(strict_types=1);

namespace App\Tests\Support;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /*
     * It is recommended to put widely used actions inside an Actor class. A good example is the 
     * login action which would probably be actively involved in acceptance or functional testing.
     *
     * Codeception allows you to share cookies between tests, so a test user can stay logged in for 
     * other tests.
     *
     * Note that session restoration only works for WebDriver modules.
     * 
     *   public function login($name, $password)
     *   {
     *       $I = $this;
     * 
     *       // if snapshot exists - skipping login
     *       if ($I->loadSessionSnapshot('login')) {
     *           return;
     *       }
     * 
     *       // Logging in
     *       $I->amOnPage('/login');
     *       $I->submitForm('#loginForm', [
     *           'login' => $name,
     *           'password' => $password
     *       ]);
     *       $I->see($name, '.navbar');
     * 
     *       // Saving snapshot
     *       $I->saveSessionSnapshot('login');
     *   }
     */

    /**
     * Define custom actions here
     */

    /* 
     * It’s recommended to prefix all your assertion actions with see or dontSee
     * 
     *    function seeClassExist($class)
     *    {
     *        $this->assertTrue(class_exists($class));
     *    }
     */
}
