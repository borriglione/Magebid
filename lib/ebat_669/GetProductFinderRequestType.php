<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'AbstractRequestType.php';

/**
 * Retrieves data that you use to construct valid "product finder" queries(queries 
 * against multiple attributes) against catalog products or (in some cases) listed 
 * items.The attributes describe search criteria (e.g., Manufacturer), as 
 * appropriate for the category.Use the results in combination with 
 * GetProductFinderXSL to render the Product Finderin a graphical user 
 * interface.<br><br>GetProductFinder does not conduct the actual product or 
 * listing search.It only returns data about what you can search on. Use the data 
 * as input toGetProductSearchResults to conduct the actual search for product 
 * informationor as input to GetSearchResults to conduct the search for listed 
 * items.(Please note that this call may not return valid product finder IDs for 
 * someGetSearchResults use cases. See the Knowledge Base article referenced below 
 * for details.)<br><br>To retrieve single-attribute search criteria (querying 
 * against a single attribute, like UPC),use GetProductSearchPage instead (only 
 * applicable for catalog searches).<br><br>See the eBay Web Services Guide for an 
 * overview of Pre-filled Item Information and details aboutsearching for catalog 
 * products and for information about searching for listed items. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetProductFinderRequestType.html
 *
 */
class GetProductFinderRequestType extends AbstractRequestType
{
	/**
	 * @var string
	 */
	protected $AttributeSystemVersion;
	/**
	 * @var int
	 */
	protected $ProductFinderID;

	/**
	 * @return string
	 */
	function getAttributeSystemVersion()
	{
		return $this->AttributeSystemVersion;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setAttributeSystemVersion($value)
	{
		$this->AttributeSystemVersion = $value;
	}
	/**
	 * @return int
	 * @param integer $index 
	 */
	function getProductFinderID($index = null)
	{
		if ($index !== null) {
			return $this->ProductFinderID[$index];
		} else {
			return $this->ProductFinderID;
		}
	}
	/**
	 * @return void
	 * @param int $value 
	 * @param  $index 
	 */
	function setProductFinderID($value, $index = null)
	{
		if ($index !== null) {
			$this->ProductFinderID[$index] = $value;
		} else {
			$this->ProductFinderID = $value;
		}
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function addProductFinderID($value)
	{
		$this->ProductFinderID[] = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetProductFinderRequestType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'AttributeSystemVersion' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'ProductFinderID' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => true,
						'cardinality' => '0..*'
					)
				));
	}
}
?>
