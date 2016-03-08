<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/03/16
 * Time: 22:29
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Api\Problem;

use NilPortugues\Assert\Assert;

/**
 * Object describing an API-Problem payload.
 *
 * @package NilPortugues\Api\Problem
 */
class ApiProblem
{
    const RFC2616 = 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html';

    /**
     * Title of the error.
     *
     * @var string
     */
    protected $title;
    /**
     * URL describing the problem type; defaults to HTTP status codes
     * @var string
     */
    protected $type = self::RFC2616;

    /**
     * Description of the specific problem.
     *
     * @var string
     */
    protected $detail = '';

    /**
     * HTTP status for the error.
     *
     * @var int
     */
    protected $status;

    /**
     * @var array
     */
    protected $additionalDetails = [];

    /**
     * Status titles for common problems
     *
     * @var array
     */
    protected static $problemStatus = [
        // CLIENT ERROR
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        // SERVER ERROR
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    /**
     * ApiProblem constructor.
     *
     * @param        $status
     * @param        $detail
     * @param string $title
     * @param string $type
     * @param array  $additionalDetails
     */
    public function __construct($status, $detail, $title = '', $type = '', array $additionalDetails = [])
    {
        $this->setTitle($title);
        $this->setType($type);
        $this->setDetail($detail);
        $this->setStatus($status);
        $this->setAdditionalDetails($additionalDetails);
    }

    /**
     * @param \Exception $exception
     * @param string     $title
     * @param string     $type
     * @param array      $additionalDetails
     *
     * @return ApiProblem
     */
    public static function fromException(\Exception $exception, $title = '', $type = '', array $additionalDetails = [])
    {
        $eCode = $exception->getCode();
        $code  = (isset($eCode) && is_int($eCode)) ? $eCode : 500;

        self::setStatus($code);

        if (0 !== strlen($type)) {
            self::setType($type);
        }


        if (0 === strlen($title) && self::type() === self::RFC2616 && array_key_exists($code, self::$problemStatus)) {
            self::setTitle(self::$problemStatus[$code]);
        } else {
            self::setTitle($title);
        }

        return new self(self::status(), $exception->getMessage(), self::title(), self::type(), $additionalDetails);
    }

    /**
     * Returns value for `additionalDetails`.
     *
     * @return array
     */
    public function additionalDetails()
    {
        return $this->additionalDetails;
    }

    /**
     * Sets the value for `additionalDetails` property.
     *
     * @param array $additionalDetails
     */
    protected function setAdditionalDetails(array &$additionalDetails)
    {
        Assert::hasKeyFormat($additionalDetails, function($key){
            Assert::isAlpha($key, 'Key requires [A-Za-z] characters only.');
        });

        $this->additionalDetails = $additionalDetails;
    }

    /**
     * Returns value for `title`.
     *
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Sets the value for `title` property.
     *
     * @param string $title
     */
    protected function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns value for `type`.
     *
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Sets the value for `type` property.
     *
     * @param string $type
     */
    protected function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns value for `detail`.
     *
     * @return string
     */
    public function detail()
    {
        return $this->detail;
    }

    /**
     * Sets the value for `detail` property.
     *
     * @param string $detail
     */
    protected function setDetail($detail)
    {
        Assert::isNotEmpty($detail, 'Detail field cannot be an empty string');

        $this->detail = $detail;
    }

    /**
     * Returns value for `status`.
     *
     * @return int
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * Sets the value for `status` property.
     *
     * @param int $status
     */
    protected function setStatus($status)
    {
        Assert::isInteger($status, 'Status must be an integer value');
        Assert::contains(array_keys(self::$problemStatus), $status, false, 'Status must be a valid HTTP 4xx or 5xx value.');

        $this->status = $status;
    }
}