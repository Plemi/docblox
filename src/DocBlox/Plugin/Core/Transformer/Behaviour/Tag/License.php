<?php
/**
 * DocBlox
 *
 * PHP Version 5
 *
 * @category   DocBlox
 * @package    Transformer
 * @subpackage Behaviours
 * @author     Mike van Riel <mike.vanriel@naenius.com>
 * @copyright  2010-2011 Mike van Riel / Naenius. (http://www.naenius.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       http://docblox-project.org
 */

/**
 * Behaviour that enables links to URLs in the @license tag.
 *
 * @category   DocBlox
 * @package    Transformer
 * @subpackage Behaviours
 * @author     David Zülke <david.zuelke@bitextender.com>
 * @author     Mike van Riel <mike.vanriel@naenius.com>
 * @copyright  2010-2011 Mike van Riel / Naenius. (http://www.naenius.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       http://docblox-project.org
 */
class DocBlox_Plugin_Core_Transformer_Behaviour_Tag_License extends
    DocBlox_Transformer_Behaviour_Abstract
{
    /**
     * Find all return tags that contain 'self' or '$this' and replace those
     * terms for the name of the current class' type.
     *
     * @param DOMDocument $xml Structure source to apply behaviour onto.
     *
     * @return DOMDocument
     */
    public function process(DOMDocument $xml)
    {
        $this->log('Linking to license URLs in @license tags');

        $licenseMap = array(
            '#^\s*(GPL|GNU General Public License)((\s?v?|version)?2)\s*$#i'
                => 'http://opensource.org/licenses/GPL-2.0',
            '#^\s*(GPL|GNU General Public License)((\s?v?|version)?3?)\s*$#i'
                => 'http://opensource.org/licenses/GPL-3.0',
            '#^\s*(LGPL|GNU (Lesser|Library) (General Public License|GPL))'
                .'((\s?v?|version)?2(\.1)?)\s*$#i'
                => 'http://opensource.org/licenses/LGPL-2.1',
            '#^\s*(LGPL|GNU (Lesser|Library) (General Public License|GPL))'
                .'((\s?v?|version)?3?)\s*$#i'
                => 'http://opensource.org/licenses/LGPL-3.0',
            '#^\s*((new |revised |modified |three-clause |3-clause )BSD'
                .'( License)?)\s*$#i'
                => 'http://opensource.org/licenses/BSD-3-Clause',
            '#^\s*((simplified |two-clause |2-clause |Free)BSD)( License)?\s*$#i'
                => 'http://opensource.org/licenses/BSD-2-Clause',
            '#^\s*MIT( License)?\s*$#i' => 'http://opensource.org/licenses/MIT',
        );

        $xpath = new DOMXPath($xml);
        $nodes = $xpath->query('//tag[@name="license"]/@description');

        /** @var DOMElement $node */
        foreach ($nodes as $node) {

            $license = $node->nodeValue;

            // FIXME: migrate to '#^' . Docblox::LINK_REGEX . '(\s+(?P<text>.+))
            // ?$#u' once that const exists
            if (preg_match(
                '#^(?i)\b(?P<url>(?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.]'
                .'[a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+'
                .'(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|'
                .'[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))(\s+(?P<text>.+))?$#u',
                $license,
                $matches
            )) {
                if (!isset($matches['text']) || !$matches['text']) {
                    // set text to URL if not present
                    $matches['text'] = $matches['url'];
                }
                $node->parentNode->setAttribute('link', $matches['url']);
                $node->nodeValue = $matches['text'];

                // bail out early
                continue;
            }

            // check map if any license matches
            foreach ($licenseMap as $regex => $url) {
                if (preg_match($regex, $license, $matches)) {
                    $node->parentNode->setAttribute('link', $url);

                    // we're done here
                    break;
                }
            }
        }

        return $xml;
    }

}