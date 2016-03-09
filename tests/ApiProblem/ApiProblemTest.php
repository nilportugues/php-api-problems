<?php


namespace NilPortugues\Tests\Api\Problem;


use NilPortugues\Api\Problem\ApiProblem;

class ApiProblemTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanConstruct()
    {
        $problem = new ApiProblem(404, 'User with id 5 not found.', 'Not Found', 'user.not_found');

        $this->assertEquals(404, $problem->status());
        $this->assertEquals('User with id 5 not found.', $problem->detail());
        $this->assertEquals('Not Found', $problem->title());
        $this->assertEquals('user.not_found', $problem->type());
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
}

