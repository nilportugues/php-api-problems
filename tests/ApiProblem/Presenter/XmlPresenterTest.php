<?php

namespace NilPortugues\Tests\Api\Problem\Presenter;

use NilPortugues\Api\Problem\ApiProblem;
use NilPortugues\Api\Problem\Presenter\XmlPresenter;

class XmlPresenterTest extends \PHPUnit_Framework_TestCase
{
    /** @var XmlPresenter  */
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

        $this->presenter = new XmlPresenter(
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
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:XXXX">
<title>Input values do not match the requirements</title>
<status>500</status>
<detail>User data is not valid.</detail>
<type>user.invalid_data</type>
<errors>
<item>
<name>username</name>
<error>Username must be at least 5 characters long.</error>
</item>
</errors>
</problem>
JSON;

        $this->assertEquals($expected, $this->presenter->contents());
    }

    public function testItCanCastObjectToString()
    {
        $expected = <<<JSON
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:XXXX">
<title>Input values do not match the requirements</title>
<status>500</status>
<detail>User data is not valid.</detail>
<type>user.invalid_data</type>
<errors>
<item>
<name>username</name>
<error>Username must be at least 5 characters long.</error>
</item>
</errors>
</problem>
JSON;

        $this->assertEquals($expected, (string) $this->presenter);
    }
}
