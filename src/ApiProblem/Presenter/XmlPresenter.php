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
 * Class XmlPresenter.
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
     *
     * @throws \Exception
     */
    public function contents()
    {
        $rows = $this->buildContent();
        $lines = [];
        $flattenedLines = $this->writeXml($rows, $lines);

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<problem xmlns="urn:ietf:rfc:7807">
$flattenedLines
</problem>
XML;
    }

    /**
     * @param array $rows
     * @param array $lines
     *
     * @return string
     */
    protected function writeXml(array $rows, array $lines = [])
    {
        foreach ($rows as $key => $value) {
            if (\is_array($value)) {
                if (\is_numeric($key)) {
                    $key = 'item';
                }
                $lines[] = sprintf("<%s>\n%s\n</%s>", $key, $this->writeXml($value), $key);
            } else {
                $lines[] = sprintf('<%s>%s</%s>', $key, $value, $key);
            }
        }

        return implode(PHP_EOL, $lines);
    }
}
