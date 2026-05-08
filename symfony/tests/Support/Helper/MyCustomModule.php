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

    // Standard module actions (methods you call in your tests)
    public function seeSpecialValue(string $value)
    {
        // Optional and mandatory parameters can be accessed through the $config property.
        $name = $this->config['name'];

        $this->assertContains($value, ['expected', 'values']);
    }
}