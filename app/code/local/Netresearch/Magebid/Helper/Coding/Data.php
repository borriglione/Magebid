<?php
/**
 * Netresearch_Magebid_Helper_Coding_Data
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Helper_Coding_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Enconding a string to UTF8
     * 
     * @param string $string 
     *
     * @return string
     */   
	public function encodeStringEbayToMagento($string)
	{
		return utf8_encode($string);
	}
	
    /**
     * Enconding a string,array or object to UTF8
     * 
     * @param string|array|object $value 
     *
     * @return string|array|object
     */   
	public function encodeAll($value)
	{		
		if (is_object($value))
		{
			foreach (get_object_vars($value) as $s_key => $s_value)
			{
				$value->$s_key = $this->encodeAll($s_value);
			}			
			return $value;
		}
		elseif (is_array($value))
		{
			foreach ($value as $s_key => $s_value)
			{
				$value[$s_key] = $this->encodeAll($s_value);
			}			
			return $value;
		}
		else
		{
			return $this->encodeStringEbayToMagento($value);
		}
	}
	
    /**
     * Enconding a one-depth-array to UTF-8
     * 
     * @param array $array 
     *
     * @return array
     */   
	public function encodeArray($array)
	{
		$return_array = array();		
		foreach ($array as $key => $value)
		{
			$return_array[$key] = $this->encodeStringEbayToMagento($value);
		}		
		return $return_array;
	}
	
    /**
     * Decode UTF-8 to ISO-8859-1
     * 
     * @param string $string 
     *
     * @return string
     */  
	public function encodeStringMagentoToEbay($string)
	{		
		return utf8_decode($string);
	}		
}

?>