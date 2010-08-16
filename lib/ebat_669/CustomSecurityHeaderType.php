<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'UserIdPasswordType.php';

/**
 * Security header used for SOAP API calls. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/CustomSecurityHeaderType.html
 *
 */
class CustomSecurityHeaderType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $eBayAuthToken;
	/**
	 * @var string
	 */
	protected $HardExpirationWarning;
	/**
	 * @var UserIdPasswordType
	 */
	protected $Credentials;
	/**
	 * @var string
	 */
	protected $NotificationSignature;

	/**
	 * @return string
	 */
	function getEBayAuthToken()
	{
		return $this->eBayAuthToken;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setEBayAuthToken($value)
	{
		$this->eBayAuthToken = $value;
	}
	/**
	 * @return string
	 */
	function getHardExpirationWarning()
	{
		return $this->HardExpirationWarning;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setHardExpirationWarning($value)
	{
		$this->HardExpirationWarning = $value;
	}
	/**
	 * @return UserIdPasswordType
	 */
	function getCredentials()
	{
		return $this->Credentials;
	}
	/**
	 * @return void
	 * @param UserIdPasswordType $value 
	 */
	function setCredentials($value)
	{
		$this->Credentials = $value;
	}
	/**
	 * @return string
	 */
	function getNotificationSignature()
	{
		return $this->NotificationSignature;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setNotificationSignature($value)
	{
		$this->NotificationSignature = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('CustomSecurityHeaderType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'eBayAuthToken' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'HardExpirationWarning' =>
					array(
						'required' => false,
						'type' => 'string',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'Credentials' =>
					array(
						'required' => false,
						'type' => 'UserIdPasswordType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'NotificationSignature' =>
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
