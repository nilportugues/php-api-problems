# PSR7 HTTP APIs Problem Response 

[![Build Status](https://travis-ci.org/nilportugues/php-api-problems.svg?branch=master)](https://travis-ci.org/nilportugues/php-api-problems)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/php-api-problems/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nilportugues/php-api-problems/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/246f4e3d-4574-4dbb-82e5-00b0008bb11e/mini.png?)](https://insight.sensiolabs.com/projects/246f4e3d-4574-4dbb-82e5-00b0008bb11e) 
[![Latest Stable Version](https://poser.pugx.org/nilportugues/api-problems/v/stable)](https://packagist.org/packages/nilportugues/api-problems) 
[![Total Downloads](https://poser.pugx.org/nilportugues/api-problems/downloads)](https://packagist.org/packages/nilportugues/api-problems) 
[![License](https://poser.pugx.org/nilportugues/api-problems/license)](https://packagist.org/packages/nilportugues/api-problems) 
[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://paypal.me/nilportugues)

PSR7 Response implementation for the [Problem Details for HTTP APIs](http://tools.ietf.org/html/draft-nottingham-http-problem-07)  specification draft.  

## Usage
 
To report a single error, all you need to do is pass in the mandatory parameters and you'll be fine.

**Using the constructor**

```php
<?php
$apiProblem = new ApiProblem(
    404,
    'User with id 5 not found.',
    'Not Found', 
    'user.not_found'
); 

$presenter = new JsonPresenter($apiProblem); //or XmlPresenter
return new ApiProblemResponse($presenter);  
```

**Using an Exception**

```php
<?php
try {
    //...your code throwing an exception
    throw new \Exception('User with id 5 not found.', 404);   
     
} catch(\Exception $exception) {

    $problem = ApiProblem::fromException($exception);
    $presenter = new JsonPresenter($apiProblem); //or XmlPresenter
    return new ApiProblemResponse($presenter);        
}
```

## Multiple Problems, one object

In order to report more than problem, you must use the additional details parameter.
 
```php
<?php
try {
    // some code of yours throws an exception... for instance:
    throw new \Exception('User data is not valid.', 500);
           
} catch(\Exception $exception) {

    $additionalDetails = [
        'errors' => [
            ['name' => 'username', 'error' => 'Username must be at least 5 characters long.'],
            ['name' => 'email', 'error' => 'Provided address is not a valid email.'],
        ],
    ]

    $apiProblem = ApiProblem::fromException(
        $exception,
        'Input values do not match the requirements',
        'user.invalid_data',
        $additionalDetails;
    ); 

    $presenter = new JsonPresenter($apiProblem); //or XmlPresenter
    
    return new ApiProblemResponse($presenter);
}
```

#### JSON Output
 
**Headers**
```
HTTP/1.1 500 Bad Request
Content-Type: application/problem+json
```   

**Body**
```json
{    
    "title": "Input values do not match the requirements",
    "status": 500,
    "detail": "User data is not valid.",
    "type": "user.invalid_data",
    "errors": [
        {
            "name": "username",
            "error": "Username must be at least 5 characters long."
        },
        {
            "name": "email",
            "error": "Provided address is not a valid email."
        }        
    ]
}
```

#### XML Output
 
**Headers**
```
HTTP/1.1 500 Bad Request
Content-Type: application/problem+xml
```   

**Body**

```xml
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
    <item>
      <name>email</name>
      <error>Provided address is not a valid email.</error>
    </item>    
  </errors>
</problem>
```

---


## Contribute

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker](https://github.com/nilportugues/php-api-problems/issues/new).
* You can grab the source code at the package's [Git repository](https://github.com/nilportugues/php-api-problems).

## Support

Get in touch with me using one of the following means:

 - Emailing me at <contact@nilportugues.com>
 - Opening an [Issue](https://github.com/nilportugues/php-api-problems/issues/new)

## Authors

* [Nil Portugués Calderó](http://nilportugues.com)
* [The Community Contributors](https://github.com/nilportugues/php-api-problems/graphs/contributors)


## License
The code base is licensed under the [MIT license](LICENSE).
