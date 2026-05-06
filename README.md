# tutorial_codeception

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
You can create different types of tests using Codeception. For example, to create a unit test, you can run:

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

You can run your tests using the following command:

```bash
vendor/bin/codecept run
```

This will execute all the tests in your project and provide a report of the results.

## Conclusion
Codeception is a powerful testing framework that allows you to write and run tests for your PHP applications. With its support for different types of testing and its easy-to-use syntax, it can help you ensure the quality and reliability of your code. For more information and advanced usage, refer to the [Codeception Documentation](https://codeception.com/docs/).

