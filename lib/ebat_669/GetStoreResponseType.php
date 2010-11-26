<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'AbstractResponseType.php';
require_once 'StoreType.php';

/**
 * Returns the data describing a seller's eBay store, including name, 
 * description,URL, and other information. The caller making the request must be 
 * the ownerof an eBay store. If the authenticated caller does not have an eBay 
 * store, theresponse is an error. A successful response contains either the 
 * complete storeconfiguration or information about the category hierarchy for the 
 * store only. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetStoreResponseType.html
 *
 */
class GetStoreResponseType extends AbstractResponseType
{
	/**
	 * @var StoreType
	 */
	protected $Store;

	/**
	 * @return StoreType
	 */
	function getStore()
	{
		return $this->Store;
	}
	/**
	 * @return void
	 * @param StoreType $value 
	 */
	function setStore($value)
	{
		$this->Store = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetStoreResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'Store' =>
					array(
						'required' => false,
						'type' => 'StoreType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
