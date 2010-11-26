<?php

//include ebay lib
require_once('lib/ebat_669/setincludepath.php');
require_once 'EbatNs_Environment.php';

/**
 * Mbid_Magebid_Model_Notification
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    Andreas Plieninger <info@plieninger.org>
 * @copyright 2010 Andreas Plieninger
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/


class Mbid_Magebid_Model_Notification extends Mage_Core_Model_Abstract
{
	protected $_raw_notification = null;

	protected $_soap = null;

	protected $_parsed = null;

	/**
     * Construct
     *
     * @return void
     */
	protected function _construct()
    {
        $this->_init('magebid/notification');

		$this->_loadSOAP();
		$this->_loadSOAPData();
    }

    private function _loadSOAP()
    {
    	$SOAP = null;
		if(isset($GLOBALS['HTTP_RAW_POST_DATA']))
			$SOAP = $GLOBALS['HTTP_RAW_POST_DATA'];

		if(empty($SOAP))
			$SOAP = file_get_contents('php://input');
		$this->_soap = $SOAP;
    }

    public function getParsedNotification()
    {
    	return $this->_parsed;
    }

    public function getDevId()
    {
		return 'test';
    }

    public function getAppId()
    {
		return 'test';
    }

    public function getCertId()
    {
		return 'test';
    }

    private function _loadSOAPData() {
    	if(!$this->_soap)
    		return $this;

    	$DOM = new DOMDocument();
		$DOM->loadXML($this->_soap);

		$Ack = $DOM->getElementsByTagName('Ack')->length > 0 ? $DOM->getElementsByTagName("Ack")->item(0)->nodeValue : false;
		$this->setData('Ack',$Ack);
		$NotifyType = $DOM->getElementsByTagName("NotificationEventName")->length > 0 ? $DOM->getElementsByTagName("NotificationEventName")->item(0)->nodeValue : false;
		$this->setData('NotificationEventName',$NotifyType);
		$eBayItemID = $DOM->getElementsByTagName("ItemID")->length > 0 ? $DOM->getElementsByTagName("ItemID")->item(0)->nodeValue : false;
		$this->setData('ItemID',$eBayItemID);
		$Timestamp = $DOM->getElementsByTagName('Timestamp')->length > 0 ? $DOM->getElementsByTagName('Timestamp')->item(0)->nodeValue : false;
		$this->setData('Timestamp',$Timestamp);
		$eBayNotificationSignature = $DOM->getElementsByTagName('NotificationSignature')->length > 0 ? $DOM->getElementsByTagName('NotificationSignature')->item(0)->nodeValue : false;
		$this->setData('NotificationSignature',$eBayNotificationSignature);

		return $this;
    }

	public function handleNotification()
	{
		if(!$this->_soap)
			return $this;

		if(!$this->checkSignature())
			return $this;

		var_dump($this->getData('NotificationEventName'));

		switch($this->getData('NotificationEventName'))
		{
			case 'FixedPriceTransaction':
				$this->_parseSOAP('GetItemTransactions');
				Mage::getModel('magebid/notification_fixedprice')
							->setData('ParsedNotification',$this->getParsedNotification())
							->handleParsedNotification();
				break;
		}


		die();
	}

	private function _parseSOAP($callName)
	{
		//this is important, because there are some erros, that some types were not found
		//[ take me some time to get it :( ]
		//Set lower Error_Reporting
		$old_error_reporting = error_reporting();
		error_reporting(E_ERROR | E_PARSE);

		//if we make a getItem call
		//$this->_sessionproxy->call('GetItem',$requestObject); calls decodeMessage (file: EbatNs_Client.php)
		//so we just calls decode message to get a nice result object/array that looks like a normal request
		//and not like a notification

		//get Sessionproxy
		$this->_sessionproxy = Mage::getModel('magebid/ebay_ebat_session')->getMagebidConnection();
		$this->_parsed = $this->_sessionproxy->decodeMessage($callName, $this->_soap, EBATNS_PARSEMODE_CALL);

		//enable old Error_Reporting
		//error_reporting($old_error_reporting);
	}

	public function checkSignature()
	{
		if($this->getData('NotificationSignature') == $this->_calculateSignature())
			return true;
		return false;
	}

	private function _calculateSignature()
	{
		$hash = $this->getData('Timestamp').$this->getDevId().$this->getAppId().$this->getCertId();

	    // H* -> H: Hex string, high nibble first, *: for all digits
	    $Signature = base64_encode(pack('H*', md5($hash)));

	    return $Signature;
	}
}