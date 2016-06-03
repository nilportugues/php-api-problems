<?php

namespace NilPortugues\Tests\Api\Problem;

use NilPortugues\Api\Problem\ApiProblem;
use NilPortugues\Api\Problem\ApiProblemResponse;
use NilPortugues\Api\Problem\Presenter\JsonPresenter;
use NilPortugues\Api\Problem\Presenter\XmlPresenter;

class ApiProblemResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testItWillCreateJsonResponse()
    {
        $exception = new \Exception('User with id 5 not found.', 404);
        $presenter = new JsonPresenter(ApiProblem::fromException($exception));
        $response = new ApiProblemResponse($presenter);

        $body = <<<JSON
{
    "title": "Not Found",
    "status": 404,
    "detail": "User with id 5 not found.",
    "type": "http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html"
}
JSON;

        $this->assertEquals($response->getBody()->getContents(), $body);
        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($response->getHeaderLine('Content-type'), 'application/problem+json');
    }

    public function testItWillCreateXmlResponse()
    {
        $exception = new \Exception('User with id 5 not found.', 404);
        $presenter = new XmlPresenter(ApiProblem::fromException($exception));
        $response = new ApiProblemResponse($presenter);

        $body = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:7807">
<title>Not Found</title>
<status>404</status>
<detail>User with id 5 not found.</detail>
<type>http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html</type>
</problem>
XML;

        $this->assertEquals($response->getBody()->getContents(), $body);
        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($response->getHeaderLine('Content-type'), 'application/problem+xml');
    }

    public function testToJson()
    {
        $response = ApiProblemResponse::json(404, 'User with id 5 not found.', 'Not Found');

        $body = <<<JSON
{
    "title": "Not Found",
    "status": 404,
    "detail": "User with id 5 not found."
}
JSON;

        $this->assertEquals($response->getBody()->getContents(), $body);
        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($response->getHeaderLine('Content-type'), 'application/problem+json');
    }

    public function testToJsonFromException()
    {
        $exception = new \Exception('User with id 5 not found.', 404);
        $response = ApiProblemResponse::fromExceptionToJson($exception);

        $body = <<<JSON
{
    "title": "Not Found",
    "status": 404,
    "detail": "User with id 5 not found.",
    "type": "http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html"
}
JSON;

        $this->assertEquals($response->getBody()->getContents(), $body);
        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($response->getHeaderLine('Content-type'), 'application/problem+json');
    }

    public function testToXml()
    {
        $response = ApiProblemResponse::xml(404, 'User with id 5 not found.', 'Not Found');

        $body = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:7807">
<title>Not Found</title>
<status>404</status>
<detail>User with id 5 not found.</detail>
</problem>
XML;

        $this->assertEquals($response->getBody()->getContents(), $body);
        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($response->getHeaderLine('Content-type'), 'application/problem+xml');
    }

    public function testToXmlFromException()
    {
        $exception = new \Exception('User with id 5 not found.', 404);
        $response = ApiProblemResponse::fromExceptionToXml($exception);

        $body = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:7807">
<title>Not Found</title>
<status>404</status>
<detail>User with id 5 not found.</detail>
<type>http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html</type>
</problem>
XML;

        $this->assertEquals($response->getBody()->getContents(), $body);
        $this->assertEquals($response->getStatusCode(), 404);
        $this->assertEquals($response->getHeaderLine('Content-type'), 'application/problem+xml');
    }
}
