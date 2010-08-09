<?php
class Netresearch_Magebid_Helper_Coding_Data extends Mage_Core_Helper_Abstract
{
	public function encodePrepareDb($string)
	{
		return utf8_encode($string);
	}
	
	public function encodeAll($value)
	{		
		if (is_object($value))
		{
			foreach (get_object_vars($value) as $s_key => $s_value)
			{
				Mage::debug($s_key,"-",$s_value);
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
		else //child
		{
			return utf8_encode($value);
		}
	}
	
	public function encodeArray($array)
	{
		$return_array = array();
		
		foreach ($array as $key => $value)
		{
			$return_array[$key] = $this->encodePrepareDb($value);
		}
		
		return $return_array;
	}
	
	public function exportEncodeHtml($string)
	{		
		return utf8_decode($string);
	}		
	
	public function exportEncodeHtmlArray($array)
	{
		$return_array = array();
		
		foreach ($array as $key => $value)
		{
			$return_array[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
		}
		
		return $return_array;
	}	
	
	public function importEncodeString($string)
	{
		//return utf8_decode($string);
		return utf8_encode($string);
	}
}

?>