<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/03/16
 * Time: 22:55
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Api\Problem\Presenter;

/**
 * Class XmlPresenter
 * @package NilPortugues\Api\Problem\Presenter
 */
class XmlPresenter extends BasePresenter implements Presenter
{
    /**
     * @return string
     */
    public function format()
    {
        return 'xml';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function contents()
    {
        $rows = $this->buildContent();
        $this->guardHasData($rows);
        $lines = $this->writeXml($rows);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:XXXX">
$lines
</problem>
XML;

    }

    /**
     * @param array $rows
     *
     * @return string
     */
    protected function writeXml(array &$rows)
    {
        $lines = [];
        foreach ($rows as $key => $value) {
            $lines[] = sprintf('<%s>%s</%s>', $key, $value, $key);
        }

        return implode(PHP_EOL, $lines);
    }

}