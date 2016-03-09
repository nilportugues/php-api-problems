<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/03/16
 * Time: 22:55.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Api\Problem\Presenter;

/**
 * Class JsonPresenter.
 */
class JsonPresenter extends BasePresenter implements Presenter
{
    /**
     * @return string
     */
    public function format()
    {
        return 'json';
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function contents()
    {
        $rows = $this->buildContent();
        $this->guardHasData($rows);

        return json_encode($rows, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
