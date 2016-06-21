<?php

namespace NilPortugues\Tests\Api\Problem;

use NilPortugues\Api\Problem\ApiProblem;

class ApiProblemTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanConstruct()
    {
        $problem = new ApiProblem(404, 'User with id 5 not found.', 'Not Found', 'user.not_found', ['errors' => ['more']]);

        $this->assertEquals(404, $problem->status());
        $this->assertEquals('User with id 5 not found.', $problem->detail());
        $this->assertEquals('Not Found', $problem->title());
        $this->assertEquals('user.not_found', $problem->type());
        $this->assertEquals(['errors' => ['more']], $problem->additionalDetails());
    }

    public function testItCanConstructFromException()
    {
        $exception = new \Exception('User with id 5 not found.', 404);
        $problem = ApiProblem::fromException($exception);

        $this->assertEquals(404, $problem->status());
        $this->assertEquals('User with id 5 not found.', $problem->detail());
        $this->assertEquals('Not Found', $problem->title());
        $this->assertEquals(ApiProblem::RFC2616, $problem->type());
    }

    public function testItCanUseExceptionName()
    {
        $exception = new \PDOException();
        $problem = ApiProblem::fromException($exception);

        $this->assertEquals(500, $problem->status());
        $this->assertEquals('PDOException', $problem->detail());
        $this->assertEquals('Internal Server Error', $problem->title());
        $this->assertEquals('http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html', $problem->type());
    }
}
