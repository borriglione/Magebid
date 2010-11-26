<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'AbstractResponseType.php';
require_once 'PromotionalSaleStatusCodeType.php';

/**
 * Contains the ID and status of a promotional sale.The Promotional Price Display 
 * feature enables sellersto apply discounts and/or free shipping across many 
 * listings. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/SetPromotionalSaleResponseType.html
 *
 */
class SetPromotionalSaleResponseType extends AbstractResponseType
{
	/**
	 * @var PromotionalSaleStatusCodeType
	 */
	protected $Status;
	/**
	 * @var long
	 */
	protected $PromotionalSaleID;

	/**
	 * @return PromotionalSaleStatusCodeType
	 */
	function getStatus()
	{
		return $this->Status;
	}
	/**
	 * @return void
	 * @param PromotionalSaleStatusCodeType $value 
	 */
	function setStatus($value)
	{
		$this->Status = $value;
	}
	/**
	 * @return long
	 */
	function getPromotionalSaleID()
	{
		return $this->PromotionalSaleID;
	}
	/**
	 * @return void
	 * @param long $value 
	 */
	function setPromotionalSaleID($value)
	{
		$this->PromotionalSaleID = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('SetPromotionalSaleResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'Status' =>
					array(
						'required' => false,
						'type' => 'PromotionalSaleStatusCodeType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'PromotionalSaleID' =>
					array(
						'required' => false,
						'type' => 'long',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
