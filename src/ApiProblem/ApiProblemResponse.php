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

use GuzzleHttp\Psr7\Response;
use NilPortugues\Api\Problem\Presenter\Presenter;

/**
 * Class ApiProblemResponse.
 */
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
}
