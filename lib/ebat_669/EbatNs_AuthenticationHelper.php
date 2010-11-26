<?php
// $Id: EbatNs_AuthenticationHelper.php,v 1.3 2008-06-13 08:51:25 michael Exp $
// $Log: EbatNs_AuthenticationHelper.php,v $
// Revision 1.3  2008-06-13 08:51:25  michael
// use getSession() on proxy
//
// Revision 1.2  2008/05/02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'EbatNs_ServiceProxy.php';
require_once 'GetRuNameRequestType.php';

class EbatNs_AuthenticationHelper
{
	protected $_cs;
	function EbatNs_AuthenticationHelper($cs)
	{
		$this->_cs = $cs;
	}
	
	function GetEbaySignInUrl($RuName, $Params = null)
	{
		$s = $this->_cs->_session;
		if ($s->getAppMode() == 0) 
			$url = 'https://signin.' . $this->_getDomainnameBySiteId($s->getSiteId()) . '/ws/eBayISAPI.dll?SignIn&';
		else 
			$url = 'https://signin.sandbox.' . $this->_getDomainnameBySiteId($s->getSiteId()) . '/ws/eBayISAPI.dll?SignIn&';
		$url .= 'runame=' . $RuName;
		if ($Params != null)
			$url .= '&ruparams=' . $Params;
		return $url;
	}
	
	function getFetchSecretId()
	{
		srand((double)microtime() * 1000000);
		$r = rand ;
		$u = uniqid(getmypid() . $r . (double)microtime() * 1000000, 1);
		$uuid = md5 ($u);
		return $uuid;
	}	
	
	function GetEbaySignInUrlFetch($RuName, $SecretId)
	{
		$s = $this->_cs->getSession();
		if ($s->getAppMode() == 0)
			$url = 'https://signin.' . $this->_getDomainnameBySiteId($s->getSiteId()) . '/ws/eBayISAPI.dll?SignIn&';
		else 
			$url = 'https://signin.sandbox.' . $this->_getDomainnameBySiteId($s->getSiteId()) . '/ws/eBayISAPI.dll?SignIn&';
		$url .= 'runame=' . $RuName . '&sid=' . $SecretId;
		return $url;
	}
	
	function _getDomainnameBySiteId($siteid = 0)
	{
		switch ($siteid) {
			case 0:
				return 'ebay.com';
			case 2:
				return 'ebay.ca';
			case 3:
				return 'ebay.co.uk';
			case 15:
				return 'ebay.au';
			case 16:
				return 'ebay.at';
			case 23:
				return 'ebay.be';
			case 71:
				return 'ebay.fr';
			case 77:
				return 'ebay.de';
			case 100:
				return 'ebaymotors.com';
			case 101:
				return 'ebay.it';
			case 123:
				return 'ebay.be';
			case 146:
				return 'ebay.nl';
			case 186:
				return 'ebay.es';
			case 193:
				return 'ebay.ch';
			case 196:
				return 'ebay.tw';
			case 201:
				return 'ebay.hk';
			case 203:
				return 'ebay.in';
			case 207:
				return 'ebay.my';
			case 211:
				return 'ebay.ph';
			case 212:
				return 'ebay.pl';
			case 216:
				return 'ebay.sg';
			case 218:
				return 'ebay.se';
			case 223:
				return 'ebay.cn';
		}
		return 'ebay.com';
	}

}

?>