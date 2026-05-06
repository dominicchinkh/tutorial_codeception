# Codeception

This is a tutorial for Codeception, a PHP testing framework. It provides examples and explanations on how to use Codeception for various types of testing, including unit tests, functional tests, and acceptance tests.

It is based on the documentation available at [Codeception Documentation](https://codeception.com/docs/).

## Getting Started
To get started with Codeception, you can install it using Composer:

```bash
composer require --dev codeception/codeception
```

After installing Codeception, you can initialize it in your project:

```bash
vendor/bin/codecept bootstrap
```
This will create the necessary directories and configuration files for your tests.

When you change the configuration, the actor classes are rebuilt automatically. If the actor classes are not created or updated as you expect, try to generate them manually with the build command:

```bash
php vendor/bin/codecept build
```

## Writing Tests
You can create different types of tests using Codeception. 

### Acceptance Tests
Acceptance tests are used to test the application from the user's perspective. They simulate user interactions with the application and verify that it behaves as expected.

For example, to create an acceptance test, you can run:

```bash
vendor/bin/codecept generate:cest Acceptance ExampleCest
```

This will create a new test file in the `tests/acceptance` directory. You can then write your test cases in this file.

With the first argument you can run all tests from one suite:

```bash 
php vendor/bin/codecept run Acceptance
```

You can provide a directory path as well. This will execute all Acceptance tests from the backend dir:

```bash
php vendor/bin/codecept run Acceptance tests/Acceptance/backend
```

To limit tests run to a single class, add a second argument. Provide a local path to the test class, from the suite directory:

```bash
php vendor/bin/codecept run Acceptance ExampleCest
php vendor/bin/codecept run tests/Acceptance/ExampleCest.php
``` 

You can further filter which tests to run by appending a method name to the class, separated by a colon:

```bash
php vendor/bin/codecept run Acceptance ExampleCest:^exampleTest$
```

In order to get more detailed output when running acceptance tests, you can use the `--steps` option:

```bash
php vendor/bin/codecept run Acceptance --steps
```

### Functional Tests
Functional tests are used to test the application as a whole, including the interaction between different components. They are similar to acceptance tests but are more focused on the internal workings of the application rather than the user interface.

For example, to create a functional test, you can run:

```bash
vendor/bin/codecept generate:cest Functional ExampleCest
```

This will create a new test file in the `tests/functional` directory. You can then write your test cases in this file.

### Unit Tests
Unit tests are used to test individual components or functions of your application in isolation. They help ensure that each part of your code works correctly on its own.

For example, to create a unit test, you can run:

```bash
vendor/bin/codecept generate:test unit ExampleTest
```

This will create a new test file in the `tests/unit` directory. You can then write your test cases in this file.

Here is an example of a simple unit test:

```php
<?php
class ExampleTest extends \Codeception\Test\Unit
{
    public function testAddition()
    {        $this->assertEquals(4, 2 + 2);
    }
}
```

### Running Tests
You can run your tests using the following command:

```bash
vendor/bin/codecept run
```

This will execute all the tests in your project and provide a report of the results.

## Conclusion
Codeception is a powerful testing framework that allows you to write and run tests for your PHP applications. With its support for different types of testing and its easy-to-use syntax, it can help you ensure the quality and reliability of your code. For more information and advanced usage, refer to the [Codeception Documentation](https://codeception.com/docs/).

