<?php


namespace Syllabus\Tests\Functional\Http;


use PHPUnit\Framework\TestCase;
use Syllabus\Controller\WordController;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;

class ApiTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testCanGetAll()
    {
        header("Content-Type: application/json");

        $wordHandler = $this->createMock(WordHandler::class);
        $patternWordHandler = $this->createMock(PatternWordHandler::class);

        $patternWordHandler->expects($this->once())
            ->method('getWordsAndPatters');

        $wordController = new WordController($patternWordHandler, $wordHandler);
        $wordController->getAll();
    }
}