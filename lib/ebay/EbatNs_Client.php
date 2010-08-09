<?php
// $Id: EbatNs_Client.php,v 1.14 2008/10/08 10:31:19 carsten Exp $
// $Log: EbatNs_Client.php,v $
// Revision 1.14  2008/10/08 10:31:19  carsten
// changed the way the meta data is stored for schema objects. Now the information is helt in a static array (in EbatNs_ComplexType) for ALL schema classes.
// Beside changes in the Core and the ComplexType class this will also need a different way how the schema-information is stored within the constructors of all generated schema-classes.
//
// Revision 1.13  2008/10/02 13:54:15  carsten
// added batched operation via curl multi
//
// Revision 1.12  2008/09/29 13:37:04  michael
// added $this->_incrementApiUsage($method) to callShoppingApiStyle()
//
// Revision 1.11  2008/06/13 08:51:56  michael
// added method getSession()
//
// Revision 1.10  2008/06/13 06:59:17  michael
// fixed php5 issue
//
// Revision 1.9  2008/06/09 13:55:56  michael
// *** empty log message ***
//
//
// Revision 1.5  2008/06/05 08:22:12  michael
// added sandbox support for shopping api
//
// Revision 1.4  2008/05/29 07:38:11  michael
// - adapted correct sandbox url for shopping api
// - use setter for token for PHP5 version
//
// Revision 1.3  2008/05/28 16:53:18  michael
// fixed and moved method getErrorsToString() to Client
//
// Revision 1.2  2008/05/02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'UserIdPasswordType.php';

require_once 'EbatNs_RequesterCredentialType.php';
require_once 'EbatNs_RequestHeaderType.php';
require_once 'EbatNs_ResponseError.php';
require_once 'EbatNs_ResponseParser.php';

require_once 'EbatNs_DataConverter.php';

class EbatNs_Client
{ 
	// endpoint for call
	protected $_ep;
	protected $_session;
	protected $_currentResult;
	protected $_parser = null; 
	// callback-methods/functions for data-handling
	protected $_hasCallbacks = false;
	protected $_callbacks = null; 
	// EbatNs_DataConverter object
	protected $_dataConverter = null;
	
	protected $_logger = null;
	protected $_parserOptions = null;
	
	protected $_paginationElementCounter = 0;
	protected $_paginationMaxElements = -1;
	
	protected $_transportOptions = array();
	protected $_loggingOptions   = array();
	protected $_callUsage = array();

	//
	// timepoint-tracing
	//
	protected $_timePoints = null;
	protected $_timePointsSEQ = null;
	
	protected $_selectorModels = array();
	protected $_activeSelectorModel = null;
	
	/**
	 * Curl MultiHandle
	 *
	 * @var mixed
	 */
	protected $mh;
	protected $useCurlBatch = false;
	protected $chMultiHandles = array();
	protected $nextMultiIndex = 0;
	protected $resultMethods = array();
	protected $responseData = array();
	
	public function startBatchOperation()
	{
	    $this->mh = curl_multi_init();
	    $this->useCurlBatch = true;
	    $this->nextMultiIndex = 0;
	}
	
	public function cleanBatchOperation()
	{
	    $this->responseData = array();
	    $this->nextMultiIndex = 0;
	    $this->mh = null;
	}
	
	/**
	 * Add the given curl-handle to an internal list and returns the index we added it to
	 *
	 * @param mixed $ch
	 * @return number
	 */
	protected function saveCurlMultiHandle($ch)
	{
	    $this->chMultiHandles[$this->nextMultiIndex] = $ch;
	    $ret = $this->nextMultiIndex;
	    $this->nextMultiIndex++;
	    
	    return $ret;
	}
	
	public function executeBatchOperation()
	{
	    // not using a batch-operation
	    if (!$this->useCurlBatch)
	        return null;
        
	    $this->_startTp('executeBatchOperation');

	    // lets execute the batch-operation
	    $running = null;
	    do {
	        curl_multi_exec($this->mh, $running);    
	    } while($running > 0);
	    
        foreach ($this->chMultiHandles as $id => $ch)
        {
	        $responseRaw = curl_multi_getcontent( $ch );
		    
    		if ( !$responseRaw )
    		{
    			$currentResult = new EbatNs_ResponseError();
    			$currentResult->raise( 'curl_error ' . curl_errno( $ch ) . ' ' . curl_error( $ch ), 80000 + 1, EBAT_SEVERITY_ERROR );
    			$this->responseData[$id] = $currentResult; 
    		} 
    		else
    		{
    			$responseBody = null;
    			if ( preg_match( "/^(.*?)\r?\n\r?\n(.*)/s", $responseRaw, $match ) )
    			{
    				$responseBody = $match[2];
    				$headerLines = split( "\r?\n", $match[1] );
    				foreach ( $headerLines as $line )
    				{
    					if ( strpos( $line, ':' ) === false )
    					{
    						$responseHeaders[0] = $line;
    						continue;
    					} 
    					list( $key, $value ) = split( ':', $line );
    					$responseHeaders[strtolower( $key )] = trim( $value );
    				} 
    			} 
    			if ($responseBody)
    				$this->logXml( $responseBody, 'Response' );
    			else
    				$this->logXml( $responseRaw, 'ResponseRaw' );
    				
    			$this->responseData[$id] = $this->decodeMessage( 
    			    $this->resultMethods[$id], 
    			    $responseBody, 
    			    EBATNS_PARSEMODE_CALL );
    		} 
    		curl_multi_remove_handle($this->mh, $ch);
        }

        curl_multi_close($this->mh);
        $this->chMultiHandles = array();
        $this->resultMethods = array();
        $this->useCurlBatch = false;
        
        $this->_stopTp('executeBatchOperation');
        $this->_logTp();
        print_r($this->_loggingOptions);
        
        // makes sense to clean this up
        // so use cleanBatchOperation once the result is proceeded
		return $this->responseData;
	}
	
	function getVersion()
	{
		return EBAY_WSDL_VERSION;
	}	
    
	function __construct($session, $converter = 'EbatNs_DataConverterIso' )
	{
		$this->_session = $session;
		if ($converter)
			$this->_dataConverter = new $converter();
		$this->_parser = null;
		
		$timeout = $session->getRequestTimeout();
		if (!$timeout)
			$timeout = 300;
		$httpCompress = $session->getUseHttpCompression();	
		
		$this->setTransportOptions(
				array(
					'HTTP_TIMEOUT'  => $timeout, 
					'HTTP_COMPRESS' => $httpCompress));
					
		if ($session->getUseStandardLogger())
			$this->useStandardLogger();
	} 
	
	function useStandardLogger()
	{
		require_once 'EbatNs_Logger.php';
		$this->attachLogger(new EbatNs_Logger(true, 'stdout', true, true));
	}
	
	function resetPaginationCounter($maxElements = -1)
	{
		$this->_paginationElementCounter = 0;
		if ($maxElements > 0)
			$this->_paginationMaxElements = $maxElements;
		else
			$this->_paginationMaxElements = -1;
	}
	
	function incrementPaginationCounter()
	{
		$this->_paginationElementCounter++;
		
		if ($this->_paginationMaxElements > 0 && ($this->_paginationElementCounter > $this->_paginationMaxElements))
			return false;
		else
			return true;
	}
	
	function getPaginationCounter()
	{
		return $this->_paginationElementCounter;
	}
	
	function setParserOption($name, $value = true)
	{
		$this->_parserOptions[$name] = $value;
	}
	
	function log( $msg, $subject = null )
	{
		if ( $this->_logger )
			$this->_logger->log( $msg, $subject );
	} 
	
	function logXml( $xmlMsg, $subject = null )
	{
		if ( $this->_logger )
			$this->_logger->logXml( $xmlMsg, $subject );
	} 
	
	function attachLogger($logger)
	{
		$this->_logger = $logger;
	}
	
	// HTTP_TIMEOUT: default 300 s
	// HTTP_COMPRESS: default true
	function setTransportOptions($options)
	{
		$this->_transportOptions = array_merge($this->_transportOptions, $options);
	}
	
	// LOG_TIMEPOINTS: true/false
	// LOG_API_USAGE: true/false
	function setLoggingOptions($options)
	{
		$this->_loggingOptions = array_merge($this->_loggingOptions, $options);
	}
	
	
	protected function _getMicroseconds()
	{
		list( $ms, $s ) = explode( ' ', microtime() );
		return floor( $ms * 1000 ) + 1000 * $s;
	} 
	
	protected function _getElapsed( $start )
	{
		return $this->_getMicroseconds() - $start;
	} 
	
	protected function _startTp( $key )
	{
		if (!$this->_loggingOptions['LOG_TIMEPOINTS'])
			return;
		
		if ( isset( $this->_timePoints[$key] ) )
			$tp = $this->_timePoints[$key];
		
		$tp['start_tp'] = time();
		
		$tp['start'] = $this->_getMicroseconds();
		$this->_timePoints[$key] = $tp;
	} 
	
	protected function _stopTp( $key )
	{
		if (!$this->_loggingOptions['LOG_TIMEPOINTS'])
			return;
		
		if ( isset( $this->_timePoints[$key]['start'] ) )
		{
			$tp = $this->_timePoints[$key];
			$tp['duration'] = $this->_getElapsed( $tp['start'] ) . 'ms';
			unset( $tp['start'] );
			$this->_timePoints[$key] = $tp;
		} 
	} 
	
	protected function _logTp()
	{
		if (!$this->_loggingOptions['LOG_TIMEPOINTS'])
			return;
		
		// log the timepoint-information
		ob_start();
		echo "<pre><br>\n";
		print_r($this->_timePoints);
		print_r("</pre><br>\n");
		$msg = ob_get_clean();
		$this->log($msg, '_EBATNS_TIMEPOINTS');
	}
	
	//
	// end timepoint-tracing
	//
	
	// callusage
	protected function _incrementApiUsage($apiCall)
	{
		if (!$this->_loggingOptions['LOG_API_USAGE'])	
			return;
		
		$this->_callUsage[$apiCall] = $this->_callUsage[$apiCall] + 1;
	}
	
	function getApiUsage()
	{
		return $this->_callUsage;
	}
	
	function getParser($tns = 'urn:ebay:apis:eBLBaseComponents', $parserOptions = null, $recreate = true)
	{
		if ($recreate)
			$this->_parser = null;
		
		if (!$this->_parser)
		{
			if ($parserOptions)
				$this->_parserOptions = $parserOptions;
			$this->_parser = new EbatNs_ResponseParser( $this, $tns, $this->_parserOptions );
		}
		return $this->_parser;
	}
	
	// should return true if the data should NOT be included to the
	// response-object !
	function _handleDataType( $typeName, $value, $mapName )
	{
		if ( $this->_hasCallbacks )
		{
			if (isset($this->_callbacks[strtolower( $typeName )]))
				$callback = $this->_callbacks[strtolower( $typeName )];
			else
				$callback = null;
			if ( $callback )
			{
				if ( is_object( $callback['object'] ) )
				{
					return call_user_method( $callback['method'], $callback['object'], $typeName, & $value, $mapName, & $this );
				} 
				else
				{
					return call_user_func( $callback['method'], $typeName, & $value, $mapName, & $this );
				} 
			} 
		} 
		return false;
	} 
	
	// $typeName as defined in Schema
	// $method (callback, either string or array with object/method)
	function setHandler( $typeName, $method )
	{
		$this->_hasCallbacks = true;
		if ( is_array( $method ) )
		{
			$callback['object'] = $method[0];
			$callback['method'] = $method[1];
		} 
		else
		{
			$callback['object'] = null;
			$callback['method'] = $method;
		} 
		
		$this->_callbacks[strtolower( $typeName )] = $callback;
	} 
	
	function _makeSessionHeader()
	{
		$cred = new UserIdPasswordType();
		$cred->setAppId($this->_session->getAppId());
		$cred->setDevId($this->_session->getDevId());
		$cred->setAuthCert($this->_session->getCertId());
		if ( $this->_session->getTokenMode() == 0 )
		{
			$cred->setUsername($this->_session->getRequestUser());
			$cred->setPassword($this->_session->getRequestPassword());
		} 
		$reqCred = new EbatNs_RequesterCredentialType();
		$reqCred->setCredentials($cred);
		
		if ( $this->_session->getTokenMode() == 1 )
		{
			$this->_session->ReadTokenFile();
			$reqCred->setEBayAuthToken($this->_session->getRequestToken());
		} 
		
		$header = new EbatNs_RequestHeaderType();
		$header->setRequesterCredentials($reqCred);
		
		return $header;
	} 
	
	function call( $method, $request, $parseMode = EBATNS_PARSEMODE_CALL )
	{
		if
		(
			$this->_activeSelectorModel
				&& $this->_selectorModels[$this->_activeSelectorModel][$method]
		)
		{
			$request->setOutputSelector
			(
				$this->_selectorModels[$this->_activeSelectorModel][$method]->getSelectorArray()
			);
		}
		
		$this->_startTp('API call ' . $method);
		$this->_incrementApiUsage($method);
		
		$this->_startTp('Encoding SOAP Message');
		
		$body = $this->encodeMessage( $method, $request );
		$header = $this->_makeSessionHeader();
		
		$message = $this->buildMessage( $body, $header );
		
		$ep = $this->_session->getApiUrl();
		$ep .= '?callname=' . $method;
		$ep .= '&siteid=' . $this->_session->getSiteId();
		$ep .= '&appid=' . $this->_session->getAppId();
		$ep .= '&version=' . $this->getVersion();
		$ep .= '&routing=default';
		$this->_ep = $ep;
		
		$this->_stopTp('Encoding SOAP Message');
		$this->_startTp('Sending SOAP Message');
		
		$responseMsg = $this->sendMessage( $message );
		
		$this->_stopTp('Sending SOAP Message');
		
		if ( $responseMsg )
		{
			$this->_startTp('Decoding SOAP Message');
			$ret = & $this->decodeMessage( $method, $responseMsg, $parseMode );
			$this->_stopTp('Decoding SOAP Message');
		}
		else
		{
			$ret = & $this->_currentResult;
		}
		
		$this->_stopTp('API call ' . $method);
		$this->_logTp();
		
		return $ret;
	} 
	
	// should return a serialized XML of the outgoing message
	function encodeMessage( $method, $request )
	{
		return $request->serialize( $method . 'Request', $request, null, true, null, $this->_dataConverter );
	} 
	// should transform the response (body) to a PHP object structure
	function decodeMessage( $method, $msg, $parseMode )
	{
		$this->_parser = new EbatNs_ResponseParser( $this, 'urn:ebay:apis:eBLBaseComponents', $this->_parserOptions ); 
		return $this->_parser->decode( $method . 'Response', $msg, $parseMode );
	} 
	// should generate a complete SOAP-envelope for the request
	function buildMessage( $body, $header )
	{
		$soap = '<?xml version="1.0" encoding="utf-8"?>';
		$soap .= '<soap:Envelope';
		$soap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
		$soap .= ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"';
		$soap .= ' xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"';
		$soap .= ' encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"';
		$soap .= ' xmlns="urn:ebay:apis:eBLBaseComponents"';
		$soap .= ' >';
		
		if ( $header )
			$soap .= $header->serialize( 'soap:Header', $header, null, true, null, null );
		
		$soap .= '<soap:Body>';
		$soap .= $body;
		$soap .= '</soap:Body>';
		$soap .= '</soap:Envelope>';
		return $soap;
	}
	
	// this method will generate a notification-style message body
	// out of a response from a call
	function _buildNotificationMessage($response, $simulatedMessageName, $tns, $addData = null)
	{
		if ($addData)
		{
			foreach($addData as $key => $value)
			{
				$response->{$key} = $value;
			}
		}		
		$response->setTypeAttribute('xmlns', $tns);
		$msgBody = $response->serialize( $simulatedMessageName, $response, isset($response->attributeValues) ? $response->attributeValues : null, true, null, $this->_dataConverter );
		
		$soap = '<?xml version="1.0" encoding="utf-8"?>';
		$soap .= '<soapenv:Envelope';
		$soap .= ' xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"';
		$soap .= ' xmlns:xsd="http://www.w3.org/2001/XMLSchema"';
		$soap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
		$soap .= '>';
		$soap .= '<soapenv:Header>';
		$soap .= '<ebl:RequesterCredentials soapenv:mustUnderstand="0" xmlns:ns="urn:ebay:apis:eBLBaseComponents" xmlns:ebl="urn:ebay:apis:eBLBaseComponents">';
		$soap .= '<ebl:NotificationSignature xmlns:ebl="urn:ebay:apis:eBLBaseComponents">invalid_simulation</ebl:NotificationSignature>';
		$soap .= '</ebl:RequesterCredentials>';
		$soap .= '</soapenv:Header>';
		$soap .= '<soapenv:Body>';
		$soap .= $msgBody;
		$soap .= '</soapenv:Body>';
		$soap .= '</soapenv:Envelope>';
		
		return $soap;
	}
	
	// should send the message to the endpoint
	// the result should be parsed out of the envelope and return as the plain
	// response-body.
	function sendMessage( $message )
	{
		$this->_currentResult = null;
		
		$this->log( $this->_ep, 'RequestUrl' );
		$this->logXml( $message, 'Request' );
		
		$timeout = $this->_transportOptions['HTTP_TIMEOUT'];
		if (!$timeout || $timeout <= 0)
			$timeout = 300;
		
		$soapaction = 'dummy';
		
		$ch = curl_init();
		$reqHeaders[] = 'Content-Type: text/xml;charset=utf-8';
		if ($this->_transportOptions['HTTP_COMPRESS'])
		{
			$reqHeaders[] = 'Accept-Encoding: gzip, deflate';
			curl_setopt( $ch, CURLOPT_ENCODING, "gzip");
			curl_setopt( $ch, CURLOPT_ENCODING, "deflate");
		}
		$reqHeaders[] = 'SOAPAction: "' . $soapaction . '"';
		
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $reqHeaders );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'ebatns;1.0' );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $message );
		curl_setopt( $ch, CURLOPT_URL, $this->_ep );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_FAILONERROR, 0 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );
		curl_setopt( $ch, CURLOPT_HTTP_VERSION, 1 );
		
		// added support for multi-threaded clients
		if (isset($this->_transportOptions['HTTP_CURL_MULTITHREADED']))
		{
			curl_setopt( $ch, CURLOPT_DNS_USE_GLOBAL_CACHE, 0 );
			// be aware of the following:
			// - CURLOPT_NOSIGNAL is NOT defined in the standard-PHP cURL ext	(PHP 4.x)
			// so the usage need a patch and rebuild of the curl.so or "inline" PHP Version
			// Not using CURLOPT_NOSIGNAL might break if any signal-handlers are installed. So
			// the usage might be recommend but it is not must.
			// curl_setopt( $ch, CURLOPT_NOSIGNAL, true);			
			
			// - using cURL together with OpenSSL absolutely needs the multi-threading
			// looking functions for OpenSSL (see http://curl.haxx.se/libcurl/c/libcurl-tutorial.html#Multi-threading)
			// As these callbacks are NOT implemented in PHP 4.x BUT in PHP 5.x you have to do the implementation
			// for your own in PHP 4.x or switch to PHP 5.x 
		}
		
		if (isset($this->_transportOptions['HTTP_VERBOSE']))
		{
			curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
			ob_start();
		}
		
		// if running in batched mode just add the call to the multi-handle
		if ($this->useCurlBatch)
		{
		   curl_multi_add_handle($this->mh, $ch);
		   return $this->saveCurlMultiHandle($ch);
		}
		
		$responseRaw = curl_exec( $ch );
		
		if ( !$responseRaw )
		{
			$this->_currentResult = new EbatNs_ResponseError();
			$this->_currentResult->raise( 'curl_error ' . curl_errno( $ch ) . ' ' . curl_error( $ch ), 80000 + 1, EBAT_SEVERITY_ERROR );
			curl_close( $ch );
			
			return null;
		} 
		else
		{
			curl_close( $ch );
			
			$responseBody = null;
			if ( preg_match( "/^(.*?)\r?\n\r?\n(.*)/s", $responseRaw, $match ) )
			{
				$responseBody = $match[2];
				$headerLines = split( "\r?\n", $match[1] );
				foreach ( $headerLines as $line )
				{
					if ( strpos( $line, ':' ) === false )
					{
						$responseHeaders[0] = $line;
						continue;
					} 
					list( $key, $value ) = split( ':', $line );
					$responseHeaders[strtolower( $key )] = trim( $value );
				} 
			} 
			
			if ($responseBody)
				$this->logXml( $responseBody, 'Response' );
			else
				$this->logXml( $responseRaw, 'ResponseRaw' );
		} 
		
		return $responseBody;
	} 
	
	function callShoppingApiStyle($method, $request, $parseMode = EBATNS_PARSEMODE_CALL)
	{
		if ($this->_session->getAppMode() == 1)
			$ep = 'http://open.api.sandbox.ebay.com/shopping';
		else
			$ep = 'http://open.api.ebay.com/shopping';
		
		$this->_incrementApiUsage($method);

		// place all data into theirs header
		$reqHeaders[] = 'X-EBAY-API-VERSION: ' . $this->getVersion();
		$reqHeaders[] = 'X-EBAY-API-APP-ID: ' . $this->_session->getAppId();
		$reqHeaders[] = 'X-EBAY-API-CALL-NAME: ' . $method;
		$siteId = $this->_session->getSiteId();
		if (empty($siteId))
			$reqHeaders[] = 'X-EBAY-API-SITE-ID: 0';
		else
			$reqHeaders[] = 'X-EBAY-API-SITE-ID: ' . $siteId;
		$reqHeaders[] = 'X-EBAY-API-REQUEST-ENCODING: XML';
		
		$body = $this->encodeMessageXmlStyle( $method, $request );
		
		$message = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$message .= $body;
		
		$this->_ep = $ep;
		
		$responseMsg = $this->sendMessageShoppingApiStyle( $message, $reqHeaders );
		
		if ( $responseMsg )
		{
			$this->_startTp('Decoding SOAP Message');
			$ret = & $this->decodeMessage( $method, $responseMsg, $parseMode );
			$this->_stopTp('Decoding SOAP Message');
		}
		else
		{
			$ret = & $this->_currentResult;
		}
		
		return $ret;
	}
	
	function sendMessageShoppingApiStyleNonCurl( $message, $extraXmlHeaders )
	{
		// this is the part for systems that are not have cURL installed 
		$transport = new EbatNs_HttpTransport();
		if (is_array($extraXmlHeaders))
			$reqHeaders = array_merge((array)$reqHeaders, $extraXmlHeaders);
		
		$responseRaw = $transport->Post($this->_ep, $message, $reqHeaders);
		if (!$responseRaw)
		{
			$this->_currentResult = new EbatNs_ResponseError();
			$this->_currentResult->raise( 'transport error (none curl) ', 90000 + 1, EBAT_SEVERITY_ERROR );
			return null;
		}
		else
		{
			if (isset($responseRaw['errors']))
			{
				$this->_currentResult = new EbatNs_ResponseError();
				$this->_currentResult->raise( 'transport error (none curl) ' . $responseRaw['errors'], 90000 + 2, EBAT_SEVERITY_ERROR );
				return null;
			}
			
			$responseBody = $responseRaw['data'];
			if ($responseBody)
				$this->logXml( $responseBody, 'Response' );
			else
				$this->logXml( $responseRaw, 'ResponseRaw' );
			
			return $responseBody;
		}
	}

	function sendMessageShoppingApiStyle( $message, $extraXmlHeaders )
	{
		$this->_currentResult = null;
		
		$this->log( $this->_ep, 'RequestUrl' );
		$this->logXml( $message, 'Request' );
		
		$timeout = $this->_transportOptions['HTTP_TIMEOUT'];
		if (!$timeout || $timeout <= 0)
			$timeout = 300;
		
		// if we have a special HttpTransport-class defined use it !
		if (class_exists('EbatNs_HttpTransport'))
			return $this->sendMessageShoppingApiStyleNonCurl($message, $extraXmlHeaders);
		
		// continue with curl support !				
		$ch = curl_init();
		
		$reqHeaders[] = 'Content-Type: text/xml;charset=utf-8';
		
		if ($this->_transportOptions['HTTP_COMPRESS'])
		{
			$reqHeaders[] = 'Accept-Encoding: gzip, deflate';
			curl_setopt( $ch, CURLOPT_ENCODING, "gzip");
			curl_setopt( $ch, CURLOPT_ENCODING, "deflate");
		}
		
		if (is_array($extraXmlHeaders))
			$reqHeaders = array_merge((array)$reqHeaders, $extraXmlHeaders);
		
		ob_start();
		print_r($reqHeaders);
		$this->log(ob_get_clean(), 'Request headers');
		
		curl_setopt( $ch, CURLOPT_URL, $this->_ep );
		
		// curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
		// curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
		
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $reqHeaders );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'ebatns;shapi;1.0' );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
		
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $message );
		
		curl_setopt( $ch, CURLOPT_FAILONERROR, 0 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );
		curl_setopt( $ch, CURLOPT_HTTP_VERSION, 1 );
		
		// added support for multi-threaded clients
		if (isset($this->_transportOptions['HTTP_CURL_MULTITHREADED']))
		{
			curl_setopt( $ch, CURLOPT_DNS_USE_GLOBAL_CACHE, 0 );
		}
		
		$responseRaw = curl_exec( $ch );
		
		if ( !$responseRaw )
		{
			$this->_currentResult = new EbatNs_ResponseError();
			$this->_currentResult->raise( 'curl_error ' . curl_errno( $ch ) . ' ' . curl_error( $ch ), 80000 + 1, EBAT_SEVERITY_ERROR );
			curl_close( $ch );
			
			return null;
		} 
		else
		{
			curl_close( $ch );
			
			$responseBody = null;
			if ( preg_match( "/^(.*?)\r?\n\r?\n(.*)/s", $responseRaw, $match ) )
			{
				$responseBody = $match[2];
				$headerLines = split( "\r?\n", $match[1] );
				foreach ( $headerLines as $line )
				{
					if ( strpos( $line, ':' ) === false )
					{
						$responseHeaders[0] = $line;
						continue;
					} 
					list( $key, $value ) = split( ':', $line );
					$responseHeaders[strtolower( $key )] = trim( $value );
				} 
			} 
			
			if ($responseBody)
				$this->logXml( $responseBody, 'Response' );
			else
				$this->logXml( $responseRaw, 'ResponseRaw' );
		} 
		
		return $responseBody;
	} 

	function callXmlStyle( $method, $request, $parseMode = EBATNS_PARSEMODE_CALL )
	{
		// Inject the Credentials into the request here !
		$request->_elements['RequesterCredentials'] = 
		    array(
				'required' => false,
				'type' => 'EbatNs_RequesterCredentialType',
				'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
				'array' => false,
				'cardinality' => '0..1');
		
		$reqCred = new EbatNs_RequesterCredentialType();
		if ( $this->_session->getTokenMode() == 0 )
		{
			$cred = new UserIdPasswordType();
			$cred->Username = $this->_session->getRequestUser();
			$cred->Password = $this->_session->getRequestPassword();
			$reqCred->Credentials = $cred;
		} 
		
		if ( $this->_session->getTokenMode() == 1 )
		{
			$this->_session->ReadTokenFile();
			$reqCred->setEBayAuthToken($this->_session->getRequestToken());
		} 
		
		$request->RequesterCredentials = $reqCred;
		
		// we support only Sandbox and Production here !
		if ($this->_session->getAppMode() == 1)
			$ep = "https://api.sandbox.ebay.com/ws/api.dll";
		else
			$ep = 'https://api.ebay.com/ws/api.dll';
		
		// place all data into theirs header
		$reqHeaders[] = 'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $this->getVersion();
		$reqHeaders[] = 'X-EBAY-API-DEV-NAME: ' . $this->_session->getDevId();
		$reqHeaders[] = 'X-EBAY-API-APP-NAME: ' . $this->_session->getAppId();
		$reqHeaders[] = 'X-EBAY-API-CERT-NAME: ' . $this->_session->getCertId();
		$reqHeaders[] = 'X-EBAY-API-CALL-NAME: ' . $method;
		$reqHeaders[] = 'X-EBAY-API-SITEID: ' . $this->_session->getSiteId();
		
		$multiPartData = null;
		if ($method == 'UploadSiteHostedPictures')
		{
			// assuming to have the picture-binary data 
			// in $request->PictureData
			$multiPartData = $request->getPictureData();
			$request->setPictureData(null);
		}
		
		$body = $this->encodeMessageXmlStyle( $method, $request );
		
		$message = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$message .= $body;
		
		$this->_ep = $ep;
		
		$responseMsg = $this->sendMessageXmlStyle( $message, $reqHeaders, $multiPartData );
		
		if ( $responseMsg )
		{
			$this->_startTp('Decoding SOAP Message');
			$ret = & $this->decodeMessage( $method, $responseMsg, $parseMode );
			$this->_stopTp('Decoding SOAP Message');
		}
		else
		{
			$ret = & $this->_currentResult;
		}
		
		return $ret;
	}
	
	// sendMessage in XmlStyle,
	// the only difference is the extra headers we use here
	function sendMessageXmlStyle( $message, $extraXmlHeaders, $multiPartImageData = null )
	{
		$this->_currentResult = null;
		
		$this->log( $this->_ep, 'RequestUrl' );
		$this->logXml( $message, 'Request' );
		
		$timeout = $this->_transportOptions['HTTP_TIMEOUT'];
		if (!$timeout || $timeout <= 0)
			$timeout = 300;
		
		$ch = curl_init();
		
		if ($multiPartImageData !== null)
		{
			$boundary = "MIME_boundary";
			
			$CRLF = "\r\n";
			
			$mp_message .= "--" . $boundary . $CRLF;
			$mp_message .= 'Content-Disposition: form-data; name="XML Payload"' . $CRLF;
			$mp_message .= 'Content-Type: text/xml;charset=utf-8' . $CRLF . $CRLF;
			$mp_message .= $message;
			$mp_message .= $CRLF;
			
			$mp_message .= "--" . $boundary . $CRLF;
			$mp_message .= 'Content-Disposition: form-data; name="dumy"; filename="dummy"' . $CRLF;
			$mp_message .= "Content-Transfer-Encoding: binary" . $CRLF;
			$mp_message .= "Content-Type: application/octet-stream" . $CRLF . $CRLF;
			$mp_message .= $multiPartImageData;
			
			$mp_message .= $CRLF;
			$mp_message .= "--" . $boundary . "--" . $CRLF;
			
			$message = $mp_message;
			
			$reqHeaders[] = 'Content-Type: multipart/form-data; boundary=' . $boundary;
			$reqHeaders[] = 'Content-Length: ' . strlen($message);
		}
		else
		{
			$reqHeaders[] = 'Content-Type: text/xml;charset=utf-8';
		}
		
		
		if ($this->_transportOptions['HTTP_COMPRESS'])
		{
			$reqHeaders[] = 'Accept-Encoding: gzip, deflate';
			curl_setopt( $ch, CURLOPT_ENCODING, "gzip");
			curl_setopt( $ch, CURLOPT_ENCODING, "deflate");
		}
		
		if (is_array($extraXmlHeaders))
			$reqHeaders = array_merge((array)$reqHeaders, $extraXmlHeaders);
		
		curl_setopt( $ch, CURLOPT_URL, $this->_ep );
		
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
		
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $reqHeaders );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'ebatns;xmlstyle;1.0' );
		curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
		
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $message );
		
		curl_setopt( $ch, CURLOPT_FAILONERROR, 0 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, 1 );
		curl_setopt( $ch, CURLOPT_HTTP_VERSION, 1 );
		
		// added support for multi-threaded clients
		if (isset($this->_transportOptions['HTTP_CURL_MULTITHREADED']))
		{
			curl_setopt( $ch, CURLOPT_DNS_USE_GLOBAL_CACHE, 0 );
		}
		
		$responseRaw = curl_exec( $ch );
		
		if ( !$responseRaw )
		{
			$this->_currentResult = new EbatNs_ResponseError();
			$this->_currentResult->raise( 'curl_error ' . curl_errno( $ch ) . ' ' . curl_error( $ch ), 80000 + 1, EBAT_SEVERITY_ERROR );
			curl_close( $ch );
			
			return null;
		} 
		else
		{
			curl_close( $ch );
			
			$responseRaw = str_replace
			(
				array
				(
					"HTTP/1.1 100 Continue\r\n\r\nHTTP/1.1 200 OK\r\n",
					"HTTP/1.1 100 Continue\n\nHTTP/1.1 200 OK\n"
				),
				array
				(
					"HTTP/1.1 200 OK\r\n",
					"HTTP/1.1 200 OK\n"
				),
				$responseRaw
			);

			$responseBody = null;
			if ( preg_match( "/^(.*?)\r?\n\r?\n(.*)/s", $responseRaw, $match ) )
			{
				$responseBody = $match[2];
				$headerLines = split( "\r?\n", $match[1] );
				foreach ( $headerLines as $line )
				{
					if ( strpos( $line, ':' ) === false )
					{
						$responseHeaders[0] = $line;
						continue;
					} 
					list( $key, $value ) = split( ':', $line );
					$responseHeaders[strtolower( $key )] = trim( $value );
				} 
			} 
			
			if ($responseBody)
				$this->logXml( $responseBody, 'Response' );
			else
				$this->logXml( $responseRaw, 'ResponseRaw' );
		} 
		
		return $responseBody;
	} 
	
	function encodeMessageXmlStyle( $method, $request )
	{
		return $request->serialize( $method . 'Request', $request, array('xmlns' => 'urn:ebay:apis:eBLBaseComponents'), true, null, $this->_dataConverter );
	}
	
	public function hasDataConverter()
	{
	    return ($this->_dataConverter !== null);
	}
	
	public function getDataConverter()
	{
	    return $this->_dataConverter;
	}
	
    public function hasCallbacks()
	{
	    return $this->_hasCallbacks;
	}
	
	/**
	 * Reformats the error data in the response to a printable text or html output
	 *
	 * @param AbstractResponseType $response	A response returned by any of the eBay API calls
	 * @param Boolean $asHtml	Flag to pass the error in htmlentities for better formating
	 * @param Boolean $addSlashes	Uses addslashes to make the error-string directly insertable to a DB
	 * @return string
	 */
	public function getErrorsToString($response, $asHtml = false, $addSlashes = true)
	{
		$errmsg = '';
		
		if (count($response->getErrors()))
			foreach ($response->getErrors() as $errorEle)
				$errmsg .= '#' . $errorEle->getErrorCode() . ' : ' . ($asHtml ? htmlentities($errorEle->getLongMessage()) :  $errorEle->getLongMessage()) . ($asHtml ? "<br>" : "\r\n");

		if ($addSlashes)
			return addslashes($errmsg);
		else   
			return $errmsg;
	}
	
	public function addSelectorModel($callName, $selectorModel, $active)
	{
		$this->_selectorModels[$selectorModel->getName()][$callName] = $selectorModel;

		if ($active)
		{
			$this->setActiveSelectorModel($selectorModel->getName());
		}
	}
	
	public function setActiveSelectorModel($selectorName)
	{
		$this->_activeSelectorModel = $selectorName;

		foreach($this->_selectorModels as $selectorModel)
		{
			foreach($selectorModel as $selectorModelCall)
			{
				if ($selectorModelCall->getName() == $selectorName)
					$selectorModelCall->setActive(true);
				else
					$selectorModelCall->setActive(false);
			}
		}
	}

	public function getSession()
	{
		return $this->_session;
	}
} 
?>