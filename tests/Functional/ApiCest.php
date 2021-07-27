<?php

namespace Syllabus\Tests\Functional;

use ApiTester;
use Codeception\Util\HttpCode;

class ApiCest
{
    public function tryPostWordThatIsAlreadyInDatabase(ApiTester $I)
    {
        $I->haveHttpHeader("Content-type", "application/json");
        $I->sendPost(
            '/word',
            [
                "wordString" => "disastrous"
            ]
        );
        $I->sendPost(
            '/word',
            [
                "wordString" => "disastrous"
            ]
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => "word is already in database"
            ]
        );
    }

    public function tryGetAll(ApiTester $I)
    {
        $I->sendGet('/word');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                "wordId" => "1",
                "wordString" => "disastrous",
                "syllabifiedString" => "dis-as-trous",
                "patterns" => [
                    "as1tr",
                    "dis1",
                    "isas5",
                    "ou2",
                    "sa2",
                    "st4r",
                    "2us"
                ]
            ]
        );
    }

    public function tryPostNewWord(ApiTester $I)
    {
        $I->haveHttpHeader("Content-type", "application/json");
        $I->sendPost(
            '/word',
            [
                "wordString" => "mistranslate"
            ]
        );
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function tryDeleteExistingWord(ApiTester $I)
    {
        $I->haveHttpHeader("Content-type", "application/json");
        $I->sendDelete('/word', [ "wordString" => "mistranslate" ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                "message" => "word successfully deleted",
                "wordString" => "mistranslate",
                "syllabifiedWord" => "mis-trans-late"
            ]
        );
    }

    public function tryDeletingNonExistingWord(ApiTester $I)
    {
        $I->haveHttpHeader("Content-type", "application/json");
        $I->sendDelete('/word', [ "wordString" => "mistranslate" ]);
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                "message" => "word mistranslate doesn't exist",
            ]
        );
    }
}
