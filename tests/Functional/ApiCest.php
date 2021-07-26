<?php

namespace Syllabus\Tests\Functional;

use ApiTester;
use Codeception\Util\HttpCode;

class ApiCest
{
    public function tryApi(ApiTester $I)
    {
        $I->sendGet('/word');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                "wordId" => "10",
                "wordString" => "system",
                "syllabifiedString" => "sys-tem",
                "patterns" => [
                    ".sy2",
                    "s4y",
                    "ys1t"
                   ]
            ]
        );
    }
}
