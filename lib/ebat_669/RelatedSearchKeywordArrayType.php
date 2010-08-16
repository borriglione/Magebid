<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';

/**
 * Container for a list of related keywords. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/RelatedSearchKeywordArrayType.html
 *
 */
class RelatedSearchKeywordArrayType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $Keyword;

	/**
	 * @return string
	 * @param integer $index 
	 */
	function getKeyword($index = null)
	{
		if ($index !== null) {
			return $this->Keyword[$index];
		} else {
			return $this->Keyword;
		}
	}
	/**
	 * @return void
	 * @param string $value 
	 * @param  $index 
	 */
	function setKeyword($value, $index = null)
	{
		if ($index !== null) {
			$this->Keyword[$index] = $value;
		} else {
			$this->Keyword = $value;
		}
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function addKeyword($value)
	{
		$this->Keyword[] = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('RelatedSearchKeywordArrayType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'Keyword' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => true,
						'cardinality' => '0..*'
					)
				));
	}
}
?>
