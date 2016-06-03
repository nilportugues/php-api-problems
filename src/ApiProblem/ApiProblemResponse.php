<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/03/16
 * Time: 23:34.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Api\Problem;

use Exception;
use GuzzleHttp\Psr7\Response;
use NilPortugues\Api\Problem\Presenter\JsonPresenter;
use NilPortugues\Api\Problem\Presenter\Presenter;
use NilPortugues\Api\Problem\Presenter\XmlPresenter;

class ApiProblemResponse extends Response
{
    /**
     * ApiProblemResponse constructor.
     *
     * @param Presenter $presenter
     */
    public function __construct(Presenter $presenter)
    {
        parent::__construct(
            $presenter->apiProblem()->status(),
            ['Content-type' => $this->responseHeader($presenter)],
            $presenter->contents()
        );
    }

    /**
     * @param Presenter $presenter
     *
     * @return string
     */
    protected function responseHeader(Presenter $presenter)
    {
        return ($presenter->format() === 'xml') ? 'application/problem+xml' : 'application/problem+json';
    }

    /**
     * @param $status
     * @param $detail
     * @param string $title
     * @param string $type
     * @param array  $additionalDetails
     *
     * @return ApiProblemResponse
     */
    public static function json($status, $detail, $title = '', $type = '', array $additionalDetails = [])
    {
        return new self(new JsonPresenter(new ApiProblem($status, $detail, $title, $type, $additionalDetails)));
    }

    /**
     * @param Exception $exception
     * @param string    $title
     * @param string    $type
     * @param array     $additionalDetails
     *
     * @return ApiProblemResponse
     */
    public static function fromExceptionToJson(
        Exception $exception,
        $title = '',
        $type = '',
        array $additionalDetails = []
    ) {
        return new self(new JsonPresenter(ApiProblem::fromException($exception, $title, $type, $additionalDetails)));
    }

    /**
     * @param $status
     * @param $detail
     * @param string $title
     * @param string $type
     * @param array  $additionalDetails
     *
     * @return ApiProblemResponse
     */
    public static function xml($status, $detail, $title = '', $type = '', array $additionalDetails = [])
    {
        return new self(new XmlPresenter(new ApiProblem($status, $detail, $title, $type, $additionalDetails)));
    }

    /**
     * @param Exception $exception
     * @param string    $title
     * @param string    $type
     * @param array     $additionalDetails
     *
     * @return ApiProblemResponse
     */
    public static function fromExceptionToXml(
        Exception $exception,
        $title = '',
        $type = '',
        array $additionalDetails = []
    ) {
        return new self(new XmlPresenter(ApiProblem::fromException($exception, $title, $type, $additionalDetails)));
    }
}
