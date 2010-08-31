<?php
/**
 * Netresearch_Magebid_Model_Session
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Session extends Mage_Core_Model_Session_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        $this->init('magebid');
    }
}
?>
