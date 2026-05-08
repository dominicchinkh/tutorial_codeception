<?php
namespace App\Tests\Support\Helper;

use Codeception\Module;

// Custom modules must extend \Codeception\Module
class MyCustomModule extends Module
{
    // Mandatory parameters should be defined in the $requiredFields property of the class
    protected array $requiredFields = ['name'];

    // For optional parameters, you should set default values. The $config property is used 
    // to define optional parameters as well as their values
    protected array $config = ['value' => '1234'];

    // HOOK: used after configuration is loaded
    public function _initialize()
    {
    }

    // HOOK: before each suite
    public function _beforeSuite($settings = array())
    {
    }

    // HOOK: after suite
    public function _afterSuite()
    {
    }

    // HOOK: before each step
    public function _beforeStep(\Codeception\Step $step)
    {
    }

    // HOOK: after each step
    public function _afterStep(\Codeception\Step $step)
    {
    }

    // HOOK: before test
    public function _before(\Codeception\TestInterface $test)
    {
    }

    // HOOK: after test
    public function _after(\Codeception\TestInterface $test)
    {
    }

    // HOOK: on fail
    public function _failed(\Codeception\TestInterface $test, $fail)
    {
        $this->debugSection('Test', []);
        
        // The _failed hook can help in debugging a failed test. You have the opportunity to save the current 
        // test's state and show it to the user

        $this->debug('Test result: ' . $test->getMetadata()->getName() . ' failed');
    }

    /*
     * Write a public method, then run the build command, and you will see the new function added into the 
     * FunctionalTester class.
     * 
     * Modules may also contain methods that are exposed for use in helper classes. Those methods start with a 
     * _ prefix and are not available in Actor classes, so can be accessed only from modules and extensions.
     * 
     * It’s recommended to prefix all your assertion actions with see or dontSee.
     * 
     */

    public function seeSpecialValue(string $value)
    {
        // Optional and mandatory parameters can be accessed through the $config property.
        $name = $this->config['name'];

        $this->assertContains($value, ['expected', 'values']);
    }
}