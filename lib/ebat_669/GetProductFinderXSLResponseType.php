<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'AbstractResponseType.php';
require_once 'XSLFileType.php';

/**
 * Retrieves the Product Finder XSL stylesheet. Apply the stylesheet to theXML 
 * returned from a call to GetProductFinder torender a form that lets a user form a 
 * multi-attribute query againsteBay catalog data.See the Developer's Guide for an 
 * overview of Pre-filled Item Informationand information on searching for catalog 
 * products. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetProductFinderXSLResponseType.html
 *
 */
class GetProductFinderXSLResponseType extends AbstractResponseType
{
	/**
	 * @var XSLFileType
	 */
	protected $XSLFile;

	/**
	 * @return XSLFileType
	 * @param integer $index 
	 */
	function getXSLFile($index = null)
	{
		if ($index !== null) {
			return $this->XSLFile[$index];
		} else {
			return $this->XSLFile;
		}
	}
	/**
	 * @return void
	 * @param XSLFileType $value 
	 * @param  $index 
	 */
	function setXSLFile($value, $index = null)
	{
		if ($index !== null) {
			$this->XSLFile[$index] = $value;
		} else {
			$this->XSLFile = $value;
		}
	}
	/**
	 * @return void
	 * @param XSLFileType $value 
	 */
	function addXSLFile($value)
	{
		$this->XSLFile[] = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetProductFinderXSLResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'XSLFile' =>
					array(
						'required' => false,
						'type' => 'XSLFileType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => true,
						'cardinality' => '0..*'
					)
				));
	}
}
?>
