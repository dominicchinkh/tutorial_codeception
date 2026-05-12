<?php


namespace App\Tests\Unit;

use Codeception\Attribute\Skip;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Support\UnitTester;

class EntityTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    
    protected function _before()
    {
    }

    public function testUserEntity()
    {
        $user = new User();
        $user->setUsername('dominic');
        $this->assertEquals('dominic', $user->getUsername());

        // According to Gemini, Argon2id is considered the "gold standard" for password hashing
        $user->setPassword(password_hash('password123', PASSWORD_ARGON2ID));
        $this->assertTrue(password_verify('password123', $user->getPassword()));

        $user->setHasAgreeTerms(true);
        $this->assertTrue($user->getHasAgreeTerms());

        //--------------------
        // Codeception\Verify

        // https://github.com/Codeception/Verify

        // This is very tiny wrapper for PHPUnit assertions, that are aimed to make tests a bit more 
        // readable. With BDD assertions influenced by Chai, Jasmine, and RSpec your assertions would be a bit closer to natural language.
        
        verify($user)->notNull();
        verify($user->getUsername())->equals('dominic');

        //------------------
        // Codeception\Stub
        
        // https://codeception.com/docs/reference/Stub
        // https://codeception.com/docs/reference/Mock

        // Instantiates a class without executing a constructor
        $userRepository = $this->make(UserRepository::class, ['find' => new User]);
        $user = $userRepository->find(1);

        // Instantiates a class instance by running constructor
        $user = $this->construct(
            User::class, 
            [], 
            ['username' => 'john', 'password' => password_hash('password123', PASSWORD_ARGON2ID), 'hasAgreeTerms' => true]
        );

        $user = $this->make(User::class, [
            'getUsername' => \Codeception\Stub\Expected::never(),
            'getPassword' => \Codeception\Stub\Expected::exactly(1),
        ]);
        $user->getPassword();

        //----------------
        // Codeception\Db

        // https://codeception.com/docs/modules/Db

        // Assessing other modules: Modules can interact with each other through the `getModule` method

        // By using the getModule function, you get access to all of the public methods and properties of the requested module

        // Modules may also contain methods that are exposed for use in helper classes. Those methods start with a _ prefix and 
        // are not available in Actor classes, so can be accessed only from modules and extensions.

        // Get entity manager by accessing module
        $em = $this->getModule('Doctrine')->em;

        // Run time configuration changes for modules can be done by calling the _reconfigure method of the module.
        // $this->getModule('MyCustomModule')->_reconfigure(['value' => '42']);

        // More about module and helper: https://codeception.com/docs/ModulesAndHelpers

        $user = new User();
        $user->setUsername('Miles');
        $user->setPassword(password_hash('password123', PASSWORD_ARGON2ID));
        
        // Doctrine uses the Data Mapper pattern, so we persist and flush via the EntityManager 
        // instead of calling $user->save()
        $em->persist($user);
        $em->flush();
        
        $this->assertEquals('Miles', $user->getUsername());
        
        // When using the Doctrine module, use seeInRepository instead of seeInDatabase.
        
        // The Doctrine and Laravel modules will clean up the created data at the end of a test. 
        // This is done by wrapping each test in a transaction and rolling it back afterwards.
        $this->tester->seeInRepository(User::class, ['username' => 'Miles']);

        //-----------------
        // Use with caution: 
        //
        // These Github projects are not maintained anymore.
        // 
        // Specify (https://github.com/Codeception/Specify)
        // Domain assertions (https://github.com/Codeception/DomainAssert)
        // AspectMock (https://github.com/Codeception/AspectMock)
    }

    /**
     * @param mixed $value
     * @example [3.14159]
     * @example ["a string"]
     * @example [["this", "is", "an", "array"]]
     * @example [{"associative": "array"}]
     */
    public function testExample($value)
    {
        $this->assertNotEmpty($value, "Expected a value");
    }
    
    // You can explain the reason to skip test in attribute
    #[Skip('this one is not needed anymore')]
    public function notAnImportantTest(): void
    {
        // Unit tests can be skipped via the attribute or by using `markTestSkipped` method
        $shouldNotBeExecuted = true;
        
        if ($shouldNotBeExecuted) {
            $this->markTestSkipped();
        }
    }
}
