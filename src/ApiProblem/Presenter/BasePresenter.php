<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/03/16
 * Time: 23:30.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Api\Problem\Presenter;

use Exception;
use NilPortugues\Api\Problem\ApiProblem;

/**
 * Class BasePresenter.
 */
abstract class BasePresenter implements Presenter
{
    /**
     * @var ApiProblem
     */
    protected $apiProblem;

    /**
     * PresenterInterface constructor.
     *
     * @param ApiProblem $apiProblem
     */
    public function __construct(ApiProblem $apiProblem)
    {
        $this->apiProblem = $apiProblem;
    }

    /**
     * Returns value for `apiProblem`.
     *
     * @return ApiProblem
     */
    public function apiProblem()
    {
        return $this->apiProblem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->contents();
    }

    /**
     * @return array
     */
    protected function buildContent()
    {
        return array_filter(
            array_merge(
                array_filter($this->apiProblem->additionalDetails()),
                array_filter([
                    'type' => $this->apiProblem->type(),
                    'status' => $this->apiProblem->status(),
                    'title' => $this->apiProblem->title(),
                    'detail' => $this->apiProblem->detail(),
                ])
            )
        );
    }

    /**
     * @param $rows
     *
     * @throws Exception
     */
    protected function guardHasData($rows)
    {
        if (empty($rows)) {
            throw new Exception('ApiProblem provided has no data.');
        }
    }
}
