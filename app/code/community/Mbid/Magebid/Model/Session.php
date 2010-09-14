<?php
/**
 * Mbid_Magebid_Model_Session
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Session extends Mage_Core_Model_Session_Abstract
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
