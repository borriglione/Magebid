<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'AbstractResponseType.php';

/**
 * Confirms the identity of the user by returning the UserID and the EIASToken 
 * belonging tothe user. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/ConfirmIdentityResponseType.html
 *
 */
class ConfirmIdentityResponseType extends AbstractResponseType
{
	/**
	 * @var string
	 */
	protected $UserID;

	/**
	 * @return string
	 */
	function getUserID()
	{
		return $this->UserID;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setUserID($value)
	{
		$this->UserID = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('ConfirmIdentityResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'UserID' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
