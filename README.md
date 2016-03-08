# PSR7 HTTP APIs Problem Response 

[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://paypal.me/nilportugues)

PSR7 Response implementation for the [Problem Details for HTTP APIs](http://tools.ietf.org/html/draft-nottingham-http-problem-07)  specification draft.  

### Usage

#### Single Problem Response 
To report a single error, all you need to do is pass in the mandatory parameters and you'll be fine.

```php
<?php
```

#### Multiple Problems Response

In order to report more than problem, you must use the additional details parameter.
 
```php
<?php
```

#### JSON Output
 
**Headers**
```
HTTP/1.1 403 Forbidden
Content-Type: application/problem+json
```   

**Body**
```json
{
  "type": "http://example.com/probs/out-of-credit",
  "title": "You do not have enough credit.",
  "detail": "Your current balance is 30, but that costs 50."
}
```

#### XML Output
 
**Headers**
```
HTTP/1.1 403 Forbidden
Content-Type: application/problem+xml
```   

**Body**

```xml
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:XXXX">
  <type>http://example.com/probs/out-of-credit</type>
  <title>You do not have enough credit.</title>
  <detail>Your current balance is 30, but that costs 50.</detail>
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