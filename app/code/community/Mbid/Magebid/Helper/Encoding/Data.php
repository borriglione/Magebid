<?php
/**
 * Mbid_Magebid_Helper_Encoding_Data
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Helper_Encoding_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Encodes the errors from eBay
     * 
     * @return string
     */		
	public function encodeErrorsFromEbay($error_message)
	{
		$error_message = html_entity_decode($error_message);
		$error_message = str_replace("<","&lt;",$error_message);
		$error_message = str_replace(">","&gt;",$error_message);		
		return $error_message;
	}
}

?>