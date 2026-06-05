<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

final class CreateUserCest
{
    public function _before(ApiTester $I): void
    {
        // Code here will be executed before each test function.
    }

    // All `public` methods will be executed as tests.
    public function createUserViaAPI(ApiTester $I): void
    {
        // https://codeception.com/docs/APITesting#Authorization
        $I->amHttpAuthenticated('service_user', '123456');

        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPost('/users', [
          'name' => 'davert', 
          'email' => 'davert@codeception.com'
        ]);

        //--------------------------------------------------
        // If API endpoint accepts JSON you can use send methods with AsJson suffix to convert 
        // data automatically

        // $I->sendPostAsJson('/users', [
        //   'name' => 'davert', 
        //   'email' => 'davert@codeception.com'
        // ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        
        $I->seeResponseContains('{"name":"davert","email":"davert@codeception.com"}');
        $I->seeResponseContainsJson(["name" => "davert", "email" => "davert@codeception.com"]);

        // JSON contains name and email fields

        // JSONPath
        // https://en.wikipedia.org/wiki/JSONPath

        $I->seeResponseJsonMatchesJsonPath('name');
        $I->seeResponseJsonMatchesXpath('//name');
        $I->seeResponseJsonMatchesJsonPath('email');
        $I->seeResponseJsonMatchesXpath('//email');

        $I->seeResponseMatchesJsonType([
            'name' => 'string',
            'email' => 'string:email'
        ]);

        // When you need to obtain a value from a response, you can use grab* methods
        $name = $I->grabDataFromResponseByJsonPath('name');
        codecept_debug($name); // ['davert']
    }
}
