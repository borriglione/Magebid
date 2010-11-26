<?php 
// $Id: EbatNs_Session.php,v 1.4 2008-06-09 10:29:36 michael Exp $
// $Log: EbatNs_Session.php,v $
// Revision 1.4  2008-06-09 10:29:36  michael
// *** empty log message ***
//
// Revision 1.3  2008/05/04 15:24:03  carsten
// *** empty log message ***
//
// Revision 1.2  2008/05/02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'EbatNs_Defines.php';

class EbatNs_Session {
  // this array holds all attribute data of the object
  protected $_props = array();
  /**
   * sets a property by name and value
   */
  function _setProp($key, $value)
  {
    $this->_props[$key] = $value;
  }
  /**
   * gets a property by name
   */
  function _getProp($key)
  {
    return $this->_props[$key];
  }
  /**
   * Read accessor of AppId.
   * The value of this property is used as the application ID in each XML request sent to the eBay API.
   * 
   * @access public 
   * @return string Value of the AppId property
   */
  function getAppId()
  {
    return $this->_props['AppId'];
  }
  /**
   * Write accessor of AppId.
   * The value of this property is used as the application ID in each XML request sent to the eBay API.
   * 
   * @access public 
   * @param string $value The new value for the AppId property
   * @return void 
   */
  function setAppId($value)
  {
    $this->_props['AppId'] = $value;
  }
  /**
   * Read accessor of DevId.
   * The value of this property is used as the developer ID in each XML request sent to the eBay API.
   * 
   * @access public 
   * @return string Value of the DevId property
   */
  function getDevId()
  {
    return $this->_props['DevId'];
  }
  /**
   * Write accessor of DevId.
   * The value of this property is used as the developer ID in each XML request sent to the eBay API.
   * 
   * @access public 
   * @param string $value The new value for the DevId property
   * @return void 
   */
  function setDevId($value)
  {
    $this->_props['DevId'] = $value;
  }
  /**
   * Read accessor of CertId.
   * The value of this property is used as the security certificate in each XML request sent to the eBay API.
   * 
   * @access public 
   * @return string Value of the CertId property
   */
  function getCertId()
  {
    return $this->_props['CertId'];
  }
  /**
   * Write accessor of CertId.
   * The value of this property is used as the security certificate in each XML request sent to the eBay API.
   * 
   * @access public 
   * @param string $value The new value for the CertId property
   * @return void 
   */
  function setCertId($value)
  {
    $this->_props['CertId'] = $value;
  }
  /**
   * Read accessor of RequestPassword.
   * Specifies the password for the user making the API call. This value is sent in the <RequestPassword> element.
   * 
   * @access public 
   * @return string Value of the RequestPassword property
   */
  function getRequestPassword()
  {
    return $this->_props['RequestPassword'];
  }
  /**
   * Write accessor of RequestPassword.
   * Specifies the password for the user making the API call. This value is sent in the <RequestPassword> element.
   * 
   * @access public 
   * @param string $value The new value for the RequestPassword property
   * @return void 
   */
  function setRequestPassword($value)
  {
    $this->_props['RequestPassword'] = $value;
  }
  /**
   * Read accessor of RequestUser.
   * Specifies the user ID making the API call. This value is sent in the <RequestUserId> element.
   * 
   * @access public 
   * @return string Value of the RequestUser property
   */
  function getRequestUser()
  {
    return $this->_props['RequestUser'];
  }
  /**
   * Write accessor of RequestUser.
   * Specifies the user ID making the API call. This value is sent in the <RequestUserId> element.
   * 
   * @access public 
   * @param string $value The new value for the RequestUser property
   * @return void 
   */
  function setRequestUser($value)
  {
    $this->_props['RequestUser'] = $value;
  }
  /**
   * Read accessor of TimeOffset.
   * Time offset of the local machine from eBay official time. Whenever using Timestamps on any calls (in and out) the information will be adapted with this value.
   * Please provide a string with relative information e.g. "+0200" for a timezone which is 2 hours infront of GMT
   * 
   * @access public 
   * @return string Value of the TimeOffset property
   */
  function getTimeOffset()
  {
    return $this->_props['TimeOffset'];
  }
  /**
   * Write accessor of TimeOffset.
   * Time offset of the local machine from eBay official time. Whenever using Timestamps on any calls (in and out) the information will be adapted with this value.
   * Please provide a string with relative information e.g. "+0200" for a timezone which is 2 hours infront of GMT
   * 
   * @access public 
   * @param string $value The new value for the TimeOffset property
   * @return void 
   */
  function setTimeOffset($value)
  {
    $this->_props['TimeOffset'] = $value;
  }
  /**
   * Read accessor of LogLevel.
   * Define the amount og information being logged to the LogFile. Use one of the following defines (or an AND combined value) :
   * 
   * @access public 
   * @return number Value of the LogLevel property
   */
  function getLogLevel()
  {
    return $this->_props['LogLevel'];
  }
  /**
   * Write accessor of LogLevel.
   * Define the amount og information being logged to the LogFile. Use one of the following defines (or an AND combined value) :
   * 
   * @access public 
   * @param number $value The new value for the LogLevel property
   * @return void 
   */
  function setLogLevel($value)
  {
    $this->_props['LogLevel'] = $value;
  }
  /**
   * Read accessor of LogFilename.
   * Filename of the log-file. If the log-fle does not exits it will be created otherwise data gets appended. Be sure of setting write-permission to the user the php process is running as (aka www).
   * Should install a mechanism to delete or roll the file once a time to not screw up your system.
   * 
   * @access public 
   * @return string Value of the LogFilename property
   */
  function getLogFilename()
  {
    return $this->_props['LogFilename'];
  }
  /**
   * Write accessor of LogFilename.
   * Filename of the log-file. If the log-fle does not exits it will be created otherwise data gets appended. Be sure of setting write-permission to the user the php process is running as (aka www).
   * Should install a mechanism to delete or roll the file once a time to not screw up your system.
   * 
   * @access public 
   * @param string $value The new value for the LogFilename property
   * @return void 
   */
  function setLogFilename($value)
  {
    $this->_props['LogFilename'] = $value;
  }
  /**
   * Read accessor of LogMode.
   * defines how to log, actually same as define in build-in error_log function :
   * 0 log to syslog (or event log on winnt)
   * 1 email (set in LogFileName)
   * 2 debugger port (set in LogFileName)
   * 3 file (set in LogFileName)
   * 
   * @access public 
   * @return number Value of the LogMode property
   */
  function getLogMode()
  {
    return $this->_props['LogMode'];
  }
  /**
   * Write accessor of LogMode.
   * defines how to log, actually same as define in build-in error_log function :
   * 0 log to syslog (or event log on winnt)
   * 1 email (set in LogFileName)
   * 2 debugger port (set in LogFileName)
   * 3 file (set in LogFileName)
   * 
   * @access public 
   * @param number $value The new value for the LogMode property
   * @return void 
   */
  function setLogMode($value)
  {
    $this->_props['LogMode'] = $value;
  }
  /**
   * Read accessor of ApiMode.
   * Defines how data is accessed. Mainly switch between direct and integration access through a local datastorage. Use one of the following:
   * EBAY_CALLMODE_DIRECT = 0
   * EBAY_CALLMODE_INTEGRATION = 1
   * 
   * @access public 
   * @return define Value of the ApiMode property
   */
  function getApiMode()
  {
    return $this->_props['ApiMode'];
  }
  /**
   * Write accessor of ApiMode.
   * Defines how data is accessed. Mainly switch between direct and integration access through a local datastorage. Use one of the following:
   * EBAY_CALLMODE_DIRECT = 0
   * EBAY_CALLMODE_INTEGRATION = 1
   * 
   * @access public 
   * @param define $value The new value for the ApiMode property
   * @return void 
   */
  function setApiMode($value)
  {
    $this->_props['ApiMode'] = $value;
  }
  /**
   * Read accessor of SiteId.
   * Defines the eBay Site from or to data will be sent. Use a numeric value or one of the following defines :
   * EBAY_SITE_GERMANY
   * EBAY_SITE_US
   * EBAY_SITE_ ...
   * 
   * @access public 
   * @return number Value of the SiteId property
   */
  function getSiteId()
  {
    return $this->_props['SiteId'];
  }
  /**
   * Write accessor of SiteId.
   * Defines the eBay Site from or to data will be sent. Use a numeric value or one of the following defines :
   * EBAY_SITE_GERMANY
   * EBAY_SITE_US
   * EBAY_SITE_ ...
   * 
   * @access public 
   * @param number $value The new value for the SiteId property
   * @return void 
   */
  function setSiteId($value)
  {
    $this->_props['SiteId'] = $value;
  }
  /**
   * Read accessor of CompatibilityLevel.
   * 
   * @access public 
   * @return string Value of the CompatibilityLevel property
   */
  function getCompatibilityLevel()
  {
    return $this->_props['CompatibilityLevel'];
  }
  /**
   * Write accessor of CompatibilityLevel.
   * 
   * @access public 
   * @param string $value The new value for the CompatibilityLevel property
   * @return void 
   */
  function setCompatibilityLevel($value)
  {
    $this->_props['CompatibilityLevel'] = $value;
  }
  /**
   * Read accessor of ErrorLevel.
   * 
   * @access public 
   * @return number Value of the ErrorLevel property
   */
  function getErrorLevel()
  {
    return $this->_props['ErrorLevel'];
  }
  /**
   * Write accessor of ErrorLevel.
   * 
   * @access public 
   * @param number $value The new value for the ErrorLevel property
   * @return void 
   */
  function setErrorLevel($value)
  {
    $this->_props['ErrorLevel'] = $value;
  }
  /**
   * Read accessor of ErrorLanguage.
   * 
   * @access public 
   * @return number Value of the ErrorLanguage property
   */
  function getErrorLanguage()
  {
    return $this->_props['ErrorLanguage'];
  }
  /**
   * Write accessor of ErrorLanguage.
   * 
   * @access public 
   * @param number $value The new value for the ErrorLanguage property
   * @return void 
   */
  function setErrorLanguage($value)
  {
    $this->_props['ErrorLanguage'] = $value;
  }
  /**
   * Read accessor of RequestTimeout.
   * 
   * @access public 
   * @return number Value of the RequestTimeout property
   */
  function getRequestTimeout()
  {
    return $this->_props['RequestTimeout'];
  }
  /**
   * Write accessor of RequestTimeout.
   * 
   * @access public 
   * @param number $value The new value for the RequestTimeout property
   * @return void 
   */
  function setRequestTimeout($value)
  {
    $this->_props['RequestTimeout'] = $value;
  }
  /**
   * Read accessor of TokenMode.
   * 
   * @access public 
   * @return boolean Value of the TokenMode property
   */
  function getTokenMode()
  {
    return $this->_props['TokenMode'];
  }
  /**
   * Write accessor of TokenMode.
   * 
   * @access public 
   * @param boolean $value The new value for the TokenMode property
   * @return void 
   */
  function setTokenMode($value)
  {
    $this->_props['TokenMode'] = $value;
  }
  /**
   * Read accessor of TokenPickupFile.
   * will be used to pickup / store the token information for this session
   * 
   * @access public 
   * @return string Value of the TokenPickupFile property
   */
  function getTokenPickupFile()
  {
    return $this->_props['TokenPickupFile'];
  }
  /**
   * Write accessor of TokenPickupFile.
   * will be used to pickup / store the token information for this session
   * 
   * @access public 
   * @param string $value The new value for the TokenPickupFile property
   * @return void 
   */
  function setTokenPickupFile($value)
  {
    $this->_props['TokenPickupFile'] = $value;
  }
  /**
   * Read accessor of TokenUsePickupFile.
   * 
   * @access public 
   * @return boolean Value of the TokenUsePickupFile property
   */
  function getTokenUsePickupFile()
  {
    return $this->_props['TokenUsePickupFile'];
  }
  /**
   * Write accessor of TokenUsePickupFile.
   * 
   * @access public 
   * @param boolean $value The new value for the TokenUsePickupFile property
   * @return void 
   */
  function setTokenUsePickupFile($value)
  {
    $this->_props['TokenUsePickupFile'] = $value;
  }
  /**
   * Read accessor of ApiUrl.
   * returns the API Url
   * 
   * @access public 
   * @return string Value of the ApiUrl property
   */
  function getApiUrl()
  {
    return $this->_props['ApiUrl'];
  }
  /**
   * Write accessor of ApiUrl.
   * returns the API Url
   * 
   * @access public 
   * @param string $value The new value for the ApiUrl property
   * @return void 
   */
  function setApiUrl($value)
  {
    $this->_props['ApiUrl'] = $value;
  }
  /**
   * Read accessor of AppMode.
   * defines which API server to call
   * EBAY_APPMODE_SANDBOX = 1
   * EBAY_APPMODE_QA = 2
   * EBAY_APPMODE_PRODUCTION = 0
   * EBAY_APPMODE_LOCALDEBUG = 100
   * 
   * @access public 
   * @return define Value of the AppMode property
   */
  function getAppMode()
  {
    return $this->_props['AppMode'];
  }
  /**
   * Read accessor of PageSize.
   * 
   * @access public 
   * @return number Value of the PageSize property
   */
  function getPageSize()
  {
    return $this->_props['PageSize'];
  }
  /**
   * Write accessor of PageSize.
   * 
   * @access public 
   * @param number $value The new value for the PageSize property
   * @return void 
   */
  function setPageSize($value)
  {
    $this->_props['PageSize'] = $value;
  }
  /**
   * Read accessor of ProxyServer.
   * ProxyServer to pass down to cURL (CURLOPT_PROXY)
   * pass as a string in format "host:port"
   * 
   * @access public 
   * @return string Value of the ProxyServer property
   */
  function getProxyServer()
  {
    return $this->_props['ProxyServer'];
  }
  /**
   * Write accessor of ProxyServer.
   * ProxyServer to pass down to cURL (CURLOPT_PROXY)
   * pass as a string in format "host:port"
   * 
   * @access public 
   * @param string $value The new value for the ProxyServer property
   * @return void 
   */
  function setProxyServer($value)
  {
    $this->_props['ProxyServer'] = $value;
  }
  /**
   * Read accessor of ProxyUidPwd.
   * ProxyServer to pass down to cURL (CURLOPT_PROXYUSERPWD)
   * use "name:password" as a string divided by colon
   * 
   * @access public 
   * @return string Value of the ProxyUidPwd property
   */
  function getProxyUidPwd()
  {
    return $this->_props['ProxyUidPwd'];
  }
  /**
   * Write accessor of ProxyUidPwd.
   * ProxyServer to pass down to cURL (CURLOPT_PROXYUSERPWD)
   * use "name:password" as a string divided by colon
   * 
   * @access public 
   * @param string $value The new value for the ProxyUidPwd property
   * @return void 
   */
  function setProxyUidPwd($value)
  {
    $this->_props['ProxyUidPwd'] = $value;
  }
  /**
   * Read accessor of ProxyServerType.
   * ProxyServer Type to pass down to cURL
   * CURLOPT_PROXYTYPE (101)
   * CURLPROXY_HTTP = 0,
   * CURLPROXY_SOCKS4 = 4,
   * CURLPROXY_SOCKS5 = 5
   * set to EBAY_NOTHING if you are using direct access (default). The cURL operation will acutally check against this value and then use the more abritrate values ProxyXXX
   * 
   * @access public 
   * @return number Value of the ProxyServerType property
   */
  function getProxyServerType()
  {
    return $this->_props['ProxyServerType'];
  }
  /**
   * Write accessor of ProxyServerType.
   * ProxyServer Type to pass down to cURL
   * CURLOPT_PROXYTYPE (101)
   * CURLPROXY_HTTP = 0,
   * CURLPROXY_SOCKS4 = 4,
   * CURLPROXY_SOCKS5 = 5
   * set to EBAY_NOTHING if you are using direct access (default). The cURL operation will acutally check against this value and then use the more abritrate values ProxyXXX
   * 
   * @access public 
   * @param number $value The new value for the ProxyServerType property
   * @return void 
   */
  function setProxyServerType($value)
  {
    $this->_props['ProxyServerType'] = $value;
  }
  /**
   * Read accessor of UseHttpCompression.
   * flag to switch to gzip-encoding for the request. default is true which should be suitable for most situation. If using a very fast internet connection with low data amounts to retrieve might be more efficient to switch the compression of.
   * You will a suitable cURL extension for using this
   * 
   * @access public 
   * @return boolean Value of the UseHttpCompression property
   */
  function getUseHttpCompression()
  {
    return $this->_props['UseHttpCompression'];
  }
  /**
   * Write accessor of UseHttpCompression.
   * flag to switch to gzip-encoding for the request. default is true which should be suitable for most situation. If using a very fast internet connection with low data amounts to retrieve might be more efficient to switch the compression of.
   * You will a suitable cURL extension for using this
   * 
   * @access public 
   * @param boolean $value The new value for the UseHttpCompression property
   * @return void 
   */
  function setUseHttpCompression($value)
  {
    $this->_props['UseHttpCompression'] = $value;
  }
  /**
   * 
   * @access private 
   * @var array 
   */
  var $_keys = array();
  /**
   * flag to switch to gzip-encoding for the request. default is true which should be suitable for most situation. If using a very fast internet connection with low data amounts to retrieve might be more efficient to switch the compression of.
   * You will a suitable cURL extension for using this
   * 
   * @access private 
   * @var array 
   */
  var $_debugSwitches = array();
  /**
   * Read accessor of SerializeFolder.
   * specifies a folder name for (de)serialization. Take care of any security issue on the folder (R/W for the www user or IUSR_xxx on IIS)
   * 
   * @access public 
   * @return string Value of the SerializeFolder property
   */
  function getSerializeFolder()
  {
    return $this->_props['SerializeFolder'];
  }
  /**
   * Write accessor of SerializeFolder.
   * specifies a folder name for (de)serialization. Take care of any security issue on the folder (R/W for the www user or IUSR_xxx on IIS)
   * 
   * @access public 
   * @param string $value The new value for the SerializeFolder property
   * @return void 
   */
  function setSerializeFolder($value)
  {
    $this->_props['SerializeFolder'] = $value;
  }
  /**
   * Read accessor of XmlEncoding.
   * use 0 for UTF-8 encoding (default)
   * as with compat-level 401 no other values are allowed
   * 
   * @access public 
   * @return number Value of the XmlEncoding property
   */
  function getXmlEncoding()
  {
    return $this->_props['XmlEncoding'];
  }
  /**
   * Write accessor of XmlEncoding.
   * use 0 for UTF-8 encoding (default)
   * as with compat-level 401 no other values are allowed
   * 
   * @access public 
   * @param number $value The new value for the XmlEncoding property
   * @return void 
   */
  function setXmlEncoding($value)
  {
    $this->_props['XmlEncoding'] = $value;
  }
  /**
   * Read accessor of DoXmlUtf8Decoding.
   * set this flag will result in decode all incoming data to iso-8859-1 using php utf8_decode.
   * 
   * @access public 
   * @return boolean Value of the DoXmlUtf8Decoding property
   */
  function getDoXmlUtf8Decoding()
  {
    return $this->_props['DoXmlUtf8Decoding'];
  }
  /**
   * Write accessor of DoXmlUtf8Decoding.
   * set this flag will result in decode all incoming data to iso-8859-1 using php utf8_decode.
   * 
   * @access public 
   * @param boolean $value The new value for the DoXmlUtf8Decoding property
   * @return void 
   */
  function setDoXmlUtf8Decoding($value)
  {
    $this->_props['DoXmlUtf8Decoding'] = $value;
  }
  /**
   * Read accessor of DoXmlUtf8Encoding.
   * set this flag will result in encode all outgoing data to uft-8 assuming the data set to the objects are in iso-8859-1 characterset.
   * 
   * @access public 
   * @return boolean Value of the DoXmlUtf8Encoding property
   */
  function getDoXmlUtf8Encoding()
  {
    return $this->_props['DoXmlUtf8Encoding'];
  }
  /**
   * Write accessor of DoXmlUtf8Encoding.
   * set this flag will result in encode all outgoing data to uft-8 assuming the data set to the objects are in iso-8859-1 characterset.
   * 
   * @access public 
   * @param boolean $value The new value for the DoXmlUtf8Encoding property
   * @return void 
   */
  function setDoXmlUtf8Encoding($value)
  {
    $this->_props['DoXmlUtf8Encoding'] = $value;
  }
  /**
   * Read accessor of RawLogMode.
   * Set to true to turn raw log-mode on
   * 
   * @access public 
   * @return boolean Value of the RawLogMode property
   */
  function getRawLogMode()
  {
    return $this->_props['RawLogMode'];
  }
  /**
   * Write accessor of RawLogMode.
   * Set to true to turn raw log-mode on
   * 
   * @access public 
   * @param boolean $value The new value for the RawLogMode property
   * @return void 
   */
  function setRawLogMode($value)
  {
    $this->_props['RawLogMode'] = $value;
  }
  /**
   * Read accessor of RawLogPath.
   * Path where to place RawLogged Files
   * 
   * @access public 
   * @return string Value of the RawLogPath property
   */
  function getRawLogPath()
  {
    return $this->_props['RawLogPath'];
  }
  /**
   * Write accessor of RawLogPath.
   * Path where to place RawLogged Files
   * 
   * @access public 
   * @param string $value The new value for the RawLogPath property
   * @return void 
   */
  function setRawLogPath($value)
  {
    $this->_props['RawLogPath'] = $value;
  }
  /**
   * Read accessor of RawLogSeq.
   * Seq No for paginated results within a Raw Logging Session, will be incremented after a log is written
   * 
   * @access public 
   * @return number Value of the RawLogSeq property
   */
  function getRawLogSeq()
  {
    return $this->_props['RawLogSeq'];
  }
  /**
   * Write accessor of RawLogSeq.
   * Seq No for paginated results within a Raw Logging Session, will be incremented after a log is written
   * 
   * @access public 
   * @param number $value The new value for the RawLogSeq property
   * @return void 
   */
  function setRawLogSeq($value)
  {
    $this->_props['RawLogSeq'] = $value;
  }
  /**
   * Read accessor of RawLogName.
   * Name of the file to write in RawLogMode, if not given the API methodname is used.
   * The resulting filename is RawLogPath + "/" + RawLogName + "_" + RawLogSeq +  ".xml"
   * 
   * @access public 
   * @return string Value of the RawLogName property
   */
  function getRawLogName()
  {
    return $this->_props['RawLogName'];
  }
  /**
   * Write accessor of RawLogName.
   * Name of the file to write in RawLogMode, if not given the API methodname is used.
   * The resulting filename is RawLogPath + "/" + RawLogName + "_" + RawLogSeq +  ".xml"
   * 
   * @access public 
   * @param string $value The new value for the RawLogName property
   * @return void 
   */
  function setRawLogName($value)
  {
    $this->_props['RawLogName'] = $value;
  }
  /**
   * 
   * @access private 
   * @var Ebay _CryptoProvider
   */
  var $_CryptoProvider = null;
  /**
   * Standard init function, should be called from the constructor(s)
   */
  function _init()
  {
    $this->_props['AppId'] = EBAY_NOTHING;
    $this->_props['DevId'] = EBAY_NOTHING;
    $this->_props['CertId'] = EBAY_NOTHING;
    $this->_props['RequestPassword'] = EBAY_NOTHING;
    $this->_props['RequestUser'] = EBAY_NOTHING;
    $this->_props['TimeOffset'] = EBAY_NOTHING;
    $this->_props['LogLevel'] = EBAY_NOTHING;
    $this->_props['LogFilename'] = EBAY_NOTHING;
    $this->_props['LogMode'] = 0;
    $this->_props['ApiMode'] = EBAY_NOTHING;
    $this->_props['SiteId'] = EBAY_NOTHING;
    $this->_props['CompatibilityLevel'] = EBAY_NOTHING;
    $this->_props['ErrorLevel'] = EBAY_NOTHING;
    $this->_props['ErrorLanguage'] = 0;
    $this->_props['RequestTimeout'] = EBAY_NOTHING;
    $this->_props['TokenMode'] = false;
    $this->_props['TokenPickupFile'] = EBAY_NOTHING;
    $this->_props['TokenUsePickupFile'] = false;
    $this->_props['ApiUrl'] = EBAY_NOTHING;
    $this->_props['AppMode'] = EBAY_NOTHING;
    $this->_props['PageSize'] = 200;
    $this->_props['ProxyServer'] = EBAY_NOTHING;
    $this->_props['ProxyUidPwd'] = EBAY_NOTHING;
    $this->_props['ProxyServerType'] = EBAY_NOTHING;
    $this->_props['UseHttpCompression'] = false;
    $this->_props['SerializeFolder'] = null;
    $this->_props['XmlEncoding'] = 0;
    $this->_props['DoXmlUtf8Decoding'] = false;
    $this->_props['DoXmlUtf8Encoding'] = false;
    $this->_props['RawLogMode'] = false;
    $this->_props['RawLogPath'] = EBAY_NOTHING;
    $this->_props['RawLogSeq'] = 1;
    $this->_props['RawLogName'] = EBAY_NOTHING;
  }
  /**
   * 
   * @access public 
   * @param string $configFile Path to a config-file (ini-style) to read main config parameters from.
   * @return boolean 
   */
  function InitFromConfig($params_arr)
  {
    /*
	$cfg = parse_ini_file($configFile);
    if ($cfg == false) {
      $this->LogMsg("config file not found", 0, E_ERROR);
    }
	*/
		
  	//Magebid comment
  	//Keyset is not used anymore
  	//Using Token Instead
    //$this->_keys['test'] = array($params_arr['sandbox']['AppId'], $params_arr['sandbox']['DevId'], $params_arr['sandbox']['CertId']);
    //$this->_keys['prod'] = array($params_arr['production']['AppId'], $params_arr['production']['DevId'], $params_arr['production']['CertId']);
   
    if (isset($params_arr['site-id']))
        $this->setSiteId($params_arr['site-id']);
    if (isset($params_arr['user']))
        $this->setRequestUser($params_arr['user']);
    if (isset($params_arr['password']))
        $this->setRequestPassword($params_arr['password']);
    if (isset($params_arr['app-mode']))
        $this->setAppMode($params_arr['app-mode']);
    if (isset($params_arr['api-mode']))
        $this->setApiMode($params_arr['api-mode']);
    if (isset($params_arr['compat-level']))
        $this->setCompatibilityLevel($params_arr['compat-level']);
    if (isset($params_arr['error-level']))
        $this->setErrorLevel($params_arr['error-level']);
    if (isset($params_arr['request-timeout']))
        $this->setRequestTimeout($params_arr['request-timeout']);
    if (isset($params_arr['serialize-folder']))
        $this->setSerializeFolder($params_arr['serialize-folder']);
    if (isset($params_arr['token-mode'])) {
      $this->setTokenMode($params_arr['token-mode']);
    if (isset($params_arr['token-pickup-file'])) {
        $this->setTokenPickupFile($params_arr['token-pickup-file']);
        $this->setTokenUsePickupFile(true);
      }
    }
    // only utf-8 encoding is allowed !!!
    $this->setXmlEncoding(0);
    if (isset($params_arr['error-language'])) {
      $this->setErrorLanguage($params_arr['error-language']);
    }else {
      $this->setErrorLanguage(0);
    }
    if (isset($params_arr['xml-extra-decode'])) {
      $this->setDoXmlUtf8Decoding($params_arr['xml-extra-decode']);
    }else {
      $this->setDoXmlUtf8Decoding(0);
    }
    if (isset($params_arr['xml-extra-encode'])) {
      $this->setDoXmlUtf8Encoding($params_arr['xml-extra-encode']);
    }else {
      $this->setDoXmlUtf8Encoding(0);
    }
    if (isset($params_arr['use-http-compression'])) {
      $this->setUseHttpCompression($params_arr['use-http-compression']);
    }
    if (isset($params_arr['log-file'])) {
      $this->setLogFilename($params_arr['log-file']);
    }
    if (isset($params_arr['log-level'])) {
      $this->setLogLevel($params_arr['log-level']);
    }
    if (isset($params_arr['log-mode'])) {
      $this->setLogMode($params_arr['log-mode']);
    }
    if (isset($params_arr['debug-showin'])) {
      $this->setDebugSwitch('showin');
    }
    if (isset($params_arr['debug-showout'])) {
      $this->setDebugSwitch('showout');
    }
    if (isset($params_arr['debug-profiling'])) {
      $this->setDebugSwitch('profiling');
    }
    if (isset($params_arr['debug-curl-verbose'])) {
      $this->setDebugSwitch('curl-verbose');
    }
    if (isset($params_arr['raw-log-mode'])) {
      $this->setRawLogMode($params_arr['raw-log-mode']);
    }
    if (isset($params_arr['raw-log-path'])) {
      $this->setRawLogPath($params_arr['raw-log-path']);
    }
    if (isset($params_arr['raw-log-name'])) {
      $this->setRawLogName($params_arr['raw-log-name']);
    }
    if (isset($params_arr['raw-log-seq'])) {
      $this->setRawLogSeq($params_arr['raw-log-seq']);
    }
    if (isset($params_arr['max-transactions-per-page'])) {
      $this->_props['PageSize'] = $params_arr['max-transactions-per-page'];
      if ($this->_props['PageSize'] <= 0)
        $this->_props['PageSize'] = 200;
    }
	
    if (isset($params_arr['use_standard_logger'])) {
		$this->setUseStandardLogger($params_arr['use_standard_logger']);
	}
  }
  /**
   * Writes a log-message to the logFile
   * 
   * @access public 
   * @param string $msg 
   * @param number $errNo 
   * @param number $severity 
   * @return void 
   */
  function LogMsg($msg, $errNo, $severity)
  {
    $dt = date("Y-m-d H:i:s (T)");
    $errStr = "$dt,#$errNo,$severity,$msg\r\n";
    $destination = $this->getLogFilename();
    switch ($this->getLogMode()) {
      case 0:
        error_log($errStr, 0);
        break;
      case 1:
        // TODO
        // assume the logfile name as an email address
        error_log($errStr, 1, $destination);
        break;
      case 2:
        // TODO
        // assume the logfile name as the debugger port
        error_log($errStr, 2, $destination);
        break;
      case 3:
        error_log($errStr, 3, $destination);
        break;
    } // switch
    // TODO
    // maybe die here on fatal errors
  }
  /**
   * special processing needed for AppMode
   * 
   * @access public 
   * @param define $value 
   * @return void 
   */
  function setAppMode($value)
  {
    $this->_props['AppMode'] = $value;
    // setting the URL for the API
    // recording to the AppMode selected
    switch ($value) {
      case 0:
        $this->_setProp('ApiUrl', 'https://api.ebay.com/wsapi');
        //$this->_setProp('AppId', $this->_keys['prod'][0]);
        //$this->_setProp('DevId', $this->_keys['prod'][1]);
        //$this->_setProp('CertId', $this->_keys['prod'][2]);
        break;
      case 1:
        $this->_setProp('ApiUrl', 'https://api.sandbox.ebay.com/wsapi');
        //$this->_setProp('AppId', $this->_keys['test'][0]);
        //$this->_setProp('DevId', $this->_keys['test'][1]);
        //$this->_setProp('CertId', $this->_keys['test'][2]);
        break;
      case 2:
        //$this->_setProp('ApiUrl', 'https://api.ebay.com/wsapi');
        //$this->_setProp('AppId', $this->_keys['test'][0]);
        //$this->_setProp('DevId', $this->_keys['test'][1]);
        //$this->_setProp('CertId', $this->_keys['test'][2]);
        break;
    }
  }
  /**
   * 
   * @access public 
   * @param string $configFile 
   * @return void 
   */
  function EbatNs_Session($params_arr)
  {
    // call to initialisation
    // (be sure to call this always on the actual class and prevent any overwriting)
	EbatNs_Session::_init();
    $this->_props['RequestToken'] = EBAY_NOTHING;	
    if (is_array($params_arr)) {
      $this->InitFromConfig($params_arr);
    }
  }
  /**
   * sets various internal debug switches
   * 
   * @access public 
   * @param string $switch use one the following switches (string)
   * 'showin' prints raw input (headers, xml)
   * 'showout' print raw output (xml)
   * 'logout' saves all ouput to a log-file with lays under /var/tmp with the name of the API-call and .log
   * 'pickoutlog' instead of making the call the log-file from 'logout' is picked up. Attention not suitable for paginated results.
   * 'profile' logs profiling information for any API-logs
   * @param boolean $onoff 
   * @return void 
   */
  function setDebugSwitch($switch, $onoff = true)
  {
    if ($onoff == true) {
      $this->_debugSwitches["$switch"] = true;
    }else {
      unset($this->_debugSwitches["$switch"]);
    }
  }
  /**
   * reads the content of the TokenFile to the Attribute RequestToken. If you are running in TokenMode the TokenFile and the Flag 'TokenUsePickupFile' is true the fill will be read whenever a call this made.
   * 
   * @access public 
   * @return void 
   */
  function ReadTokenFile()
  {
    if ($this->getTokenUsePickupFile()) {
      $fname = $this->getTokenPickupFile();
      $fh = fopen($fname, "r");
      $this->_props['RequestToken'] = trim(fread($fh, filesize($fname)));
      fclose($fh);
    }
  }
  /**
   * Writes the content of the Attribute RequestToken to the TokenFile. If the ApiCaller detects a RefreshToken after a call the new token will get automatically writen to the file.
   * 
   * @access public 
   * @return void 
   */
  function WriteTokenFile()
  {
    if ($this->getTokenUsePickupFile()) {
      $fname = $this->getTokenPickupFile();
      $fh = fopen($fname, "w+");
      fwrite($fh, $this->_props['RequestToken']);
      fclose($fh);
    }
  }
  /**
   * 
   * @access public 
   * @param  $ <unspecified> $data
   * @return void 
   */
  function EncyrptData($data)
  {
    if ($this->_CryptoProvider != null)
      return $this->_CryptoProvider->Encrypt($data);
    else
      return $data;
  }
  /**
   * 
   * @access public 
   * @param  $ <unspecified> $data
   * @return void 
   */
  function DecyrptData($data)
  {
    if ($this->_CryptoProvider != null)
      return $this->_CryptoProvider->Decrypt($data);
    else
      return $data;
  }
  /**
   * 
   * @access public 
   * @param Ebay $ _CryptoProvider $provider
   * @return void 
   */
  function setCryptoProvider($provider)
  {
    $this->_CryptoProvider = $provider;
  }
  /**
   * 
   * @access public 
   * @return void 
   */
  function getRequestToken()
  {
    return $this->DecyrptData($this->_props['RequestToken']);
  }
  /**
   * 
   * @access public 
   * @param string $value 
   * @return void 
   */
  function setRequestToken($value)
  {
    $this->_props['RequestToken'] = $this->EncyrptData($value);
  }

  /**
   * 
   * @access public 
   * @param string $value 
   * @return void 
   */
  function setUseStandardLogger($value)
  {
    $this->_props['UseStandardLogger'] = $value;
  }
  /**
   * 
   * @access public 
   * @return void 
   */
  function getUseStandardLogger()
  {
    return ($this->_props['UseStandardLogger'] ? true : false);
  }
}

?>