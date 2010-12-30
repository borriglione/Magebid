<?php
/**
 * Mbid_Magebid_Helper_Data
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Calculates the difference between two dates in days
     * 
     * @param string $fromDatetime From Date
     * @param string $toDatetime To Date
     *
     * @return double
     */	
	public function calculateDaysBetweenTwoDatetimes($fromDatetime,$toDatetime)
	{
		$fromTimestamp = $this->_makeTimestamp($fromDatetime);
		$toTimestamp = $this->_makeTimestamp($toDatetime);
		$difference = $toTimestamp-$fromTimestamp;
		
		//Format difference seconds in days and return
		$difference = $difference/(60*60*24);
		return $difference;
	}
	
    /**
     * Creates Timestamp
     * 
     * @param string $datetime
     *
     * @return int
     */	
	protected function _makeTimestamp($datetime)
	{
		return strtotime($datetime);
	}
	
    /**
     * Replace https with http to avoid SSL-Problems
     * 
     * eBay only allow http or ftp but not https
     * 
     * @param string $url
     *
     * @return string
     */	
	public function replaceHttps($url)
	{
		return str_replace("https","http",$url);
	}
}

?>