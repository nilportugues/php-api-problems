<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/03/16
 * Time: 22:57.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Api\Problem\Presenter;

use NilPortugues\Api\Problem\ApiProblem;

/**
 * Class PresenterInterface.
 */
interface Presenter
{
    /**
     * PresenterInterface constructor.
     *
     * @param ApiProblem $apiProblem
     */
    public function __construct(ApiProblem $apiProblem);

    /**
     * @return ApiProblem
     */
    public function apiProblem();

    /**
     * @return string
     */
    public function format();

    /**
     * @return string
     */
    public function contents();

    /**
     * @return string
     */
    public function __toString();
}
