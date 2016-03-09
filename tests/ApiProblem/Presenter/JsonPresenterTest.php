<?php

namespace NilPortugues\Tests\Api\Problem\Presenter;

use NilPortugues\Api\Problem\ApiProblem;
use NilPortugues\Api\Problem\Presenter\JsonPresenter;

class JsonPresenterTest extends \PHPUnit_Framework_TestCase
{
    /** @var JsonPresenter  */
    protected $presenter;

    public function setUp()
    {
        $additionalDetails = [
            'errors' => [
                [
                    'name' => 'username',
                    'error' => 'Username must be at least 5 characters long.',
                ],
            ],
        ];

        $this->presenter = new JsonPresenter(
            ApiProblem::fromException(
                new \Exception('User data is not valid.', 500),
                'Input values do not match the requirements',
                'user.invalid_data',
                $additionalDetails
            )
        );
    }

    public function testItCanWriteXmlFromNestedArray()
    {
        $expected = <<<JSON
{
    "detail": "User data is not valid.",
    "title": "Input values do not match the requirements",
    "status": 500,
    "type": "user.invalid_data",
    "errors": [
        {
            "name": "username",
            "error": "Username must be at least 5 characters long."
        }
    ]
}
JSON;

        $this->assertEquals($expected, $this->presenter->contents());
    }

    public function testItCanCastObjectToString()
    {
        $expected = <<<JSON
{
    "detail": "User data is not valid.",
    "title": "Input values do not match the requirements",
    "status": 500,
    "type": "user.invalid_data",
    "errors": [
        {
            "name": "username",
            "error": "Username must be at least 5 characters long."
        }
    ]
}
JSON;

        $this->assertEquals($expected, (string) $this->presenter);
    }
}
