<?php 
// $Id: EbatNs_Result.php,v 1.2 2008-05-02 15:04:05 carsten Exp $
// $Log: EbatNs_Result.php,v $
// Revision 1.2  2008-05-02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'EbatNs_Defines.php';
/**
 * DEFINE("EBAY_ERR_SUCCESS", "0");
 * DEFINE("EBAY_ERR_ERROR", "1");
 * DEFINE("EBAY_ERR_WARNING", "2");
 */
class EbatNs_Result {
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
   * 
   * @access private 
   * @var array 
   */
  protected $_errors = array();
  /**
   * 
   * @access private 
   * @var define 
   */
  protected $_errorSeverity = EBAY_ERR_SUCCESS;
  /**
   * 
   * @access private 
   * @var number 
   */
  protected $_actualPage = 0;
  /**
   * 
   * @access private 
   * @var number 
   */
  protected $_numberPages = 1;
  /**
   * 
   * @access private 
   * @var boolean 
   */
  protected $_userBreak = false;
  /**
   * 
   * @access private 
   * @var array 
   */
  protected $_xmlValues = null;
  /**
   * 
   * @access private 
   * @var array 
   */
  protected $_xmlTags = null;
  /**
   * Read accessor to the ResultMessages.
   * Holds any additional message from the eBay system (e.g. Item->Add() will return a message, or Item->End() will return the end-time here)
   * 
   * @access public 
   * @param integer $index The index of the value to return
   * @return string Value of the ResultMessages property
   */
  function getResultMessages($index)
  {
    return $this->_props['ResultMessages'][$index];
  }
  /**
   * Return the amount of ResultMessages actually declared
   * 
   * @access public 
   * @return string Value of the ResultMessages property
   */
  function getResultMessagesCount()
  {
    return count($this->_props['ResultMessages']);
  }
  /**
   * Returns a copy of the ResultMessages array
   * 
   * @access public 
   * @return array of string
   */
  function getResultMessagesArray()
  {
    return $this->_props['ResultMessages'];
  }
  /**
   * Write accessor to the ResultMessages.
   * Holds any additional message from the eBay system (e.g. Item->Add() will return a message, or Item->End() will return the end-time here)
   * 
   * @access public 
   * @param string $value The new value for the ResultMessages property
   * @param integer $index The index of the value to update. if $index = -1, the value is added to the end of list.
   * @return void 
   */
  function setResultMessages($value, $index = -1)
  {
    if (-1 == $index) {
      $index = count($this->_props['ResultMessages']);
    }
    $this->_props['ResultMessages'][$index] = $value;
  }
  /**
   * Read accessor of ResultStatus.
   * Could be used to return various status information codes about success or failure of the calls.
   * 
   * @access public 
   * @return string Value of the ResultStatus property
   */
  function getResultStatus()
  {
    return $this->_props['ResultStatus'];
  }
  /**
   * Write accessor of ResultStatus.
   * Could be used to return various status information codes about success or failure of the calls.
   * 
   * @access public 
   * @param string $value The new value for the ResultStatus property
   * @return void 
   */
  function setResultStatus($value)
  {
    $this->_props['ResultStatus'] = $value;
  }
  /**
   * Read accessor of HasRefreshedToken.
   * 
   * @access public 
   * @return boolean Value of the HasRefreshedToken property
   */
  function getHasRefreshedToken()
  {
    return $this->_props['HasRefreshedToken'];
  }
  /**
   * Write accessor of HasRefreshedToken.
   * 
   * @access public 
   * @param boolean $value The new value for the HasRefreshedToken property
   * @return void 
   */
  function setHasRefreshedToken($value)
  {
    $this->_props['HasRefreshedToken'] = $value;
  }
  /**
   * Read accessor of HasNewTokenHardExpirationDate.
   * 
   * @access public 
   * @return boolean Value of the HasNewTokenHardExpirationDate property
   */
  function getHasNewTokenHardExpirationDate()
  {
    return $this->_props['HasNewTokenHardExpirationDate'];
  }
  /**
   * Write accessor of HasNewTokenHardExpirationDate.
   * 
   * @access public 
   * @param boolean $value The new value for the HasNewTokenHardExpirationDate property
   * @return void 
   */
  function setHasNewTokenHardExpirationDate($value)
  {
    $this->_props['HasNewTokenHardExpirationDate'] = $value;
  }
  /**
   * Read accessor of RefreshedToken.
   * 
   * @access public 
   * @return string Value of the RefreshedToken property
   */
  function getRefreshedToken()
  {
    return $this->_props['RefreshedToken'];
  }
  /**
   * Write accessor of RefreshedToken.
   * 
   * @access public 
   * @param string $value The new value for the RefreshedToken property
   * @return void 
   */
  function setRefreshedToken($value)
  {
    $this->_props['RefreshedToken'] = $value;
  }
  /**
   * Read accessor of HardExpirationDateToken.
   * 
   * @access public 
   * @return datetime Value of the HardExpirationDateToken property
   */
  function getHardExpirationDateToken()
  {
    return $this->_props['HardExpirationDateToken'];
  }
  /**
   * Write accessor of HardExpirationDateToken.
   * 
   * @access public 
   * @param datetime $value The new value for the HardExpirationDateToken property
   * @return void 
   */
  function setHardExpirationDateToken($value)
  {
    $this->_props['HardExpirationDateToken'] = $value;
  }
  /**
   * Read accessor of SingleValue.
   * Various API Methods might return data as a single (scalar) value. All method will return an Ebay_Result, if a method needs to return a single value beside, it should set the value to the result object.
   * 
   * @access public 
   * @return <unspecified> Value of the SingleValue property
   */
  function getSingleValue()
  {
    return $this->_props['SingleValue'];
  }
  /**
   * Write accessor of SingleValue.
   * Various API Methods might return data as a single (scalar) value. All method will return an Ebay_Result, if a method needs to return a single value beside, it should set the value to the result object.
   * 
   * @access public 
   * @param  $ <unspecified> $value The new value for the SingleValue property
   * @return void 
   */
  function setSingleValue($value)
  {
    $this->_props['SingleValue'] = $value;
  }
  /**
   * Read accessor of RawLogSeq.
   * return the final SeqNo when RawLogMode is used
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
   * return the final SeqNo when RawLogMode is used
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
   * Read accessor of RawResult.
   * holds the rawResult (XML) data. Only set if specified to the call method in the apiCaller
   * 
   * @access public 
   * @return string Value of the RawResult property
   */
  function getRawResult()
  {
    return $this->_props['RawResult'];
  }
  /**
   * Write accessor of RawResult.
   * holds the rawResult (XML) data. Only set if specified to the call method in the apiCaller
   * 
   * @access public 
   * @param string $value The new value for the RawResult property
   * @return void 
   */
  function setRawResult($value)
  {
    $this->_props['RawResult'] = $value;
  }
  /**
   * Standard init function, should be called from the constructor(s)
   */
  function _init()
  {
    $this->_props['ResultMessages'] = array();
    $this->_props['ResultStatus'] = '';
    $this->_props['HasRefreshedToken'] = false;
    $this->_props['HasNewTokenHardExpirationDate'] = false;
    $this->_props['RefreshedToken'] = EBAY_NOTHING;
    $this->_props['HardExpirationDateToken'] = EBAY_NOTHING;
    $this->_props['SingleValue'] = EBAY_NOTHING;
    $this->_props['RawLogSeq'] = 0;
    $this->_props['RawResult'] = EBAY_NOTHING;
  }
  /**
   * 
   * @access public 
   * @return boolean 
   */
  function anyErrors()
  {
    return ($this->_errorSeverity == EBAY_ERR_ERROR) && (count($this->_errors) > 0);
  }
  /**
   * 
   * @access public 
   * @param number $index 
   * @return string 
   */
  function getErrorMessage($index)
  {
    if (count($this->_errors) >= $index) {
      // only returning short-message here for now
      if (array_key_exists('LongMessage', $this->_errors[$index])) {
        return htmlentities($this->_errors[$index]['LongMessage']);
      }else {
        if (array_key_exists('ShortMessage', $this->_errors[$index])) {
          return htmlentities($this->_errors[$index]['ShortMessage']);
        }else {
          return "msg not found";
        }
      }
    }else {
      return "no error or wrong index";
    }
  }
  /**
   * 
   * @access public 
   * @param number $index 
   * @return string 
   */
  function getErrorCode($index)
  {
    if (count($this->_errors) >= $index) {
      return $this->_errors[$index]['Code'];
    }else {
      return "no error or wrong index";
    }
  }
  /**
   * return the error severity as a numeric value. You can use to test on one of following defines:
   * EBAY_ERR_SUCCESS (equal to EBAY _ERR_OK)
   * EBAY_ERR_WARNING
   * EBAY_ERR_ERROR
   * 
   * @access public 
   * @return define 
   */
  function getErrorSeverity()
  {
    return $this->_errorSeverity;
  }
  /**
   * 
   * @access public 
   * @return number 
   */
  function getActualPage()
  {
    return $this->_actualPage;
  }
  /**
   * 
   * @access public 
   * @return number 
   */
  function getNumberOfPages()
  {
    return $this->_numberPages;
  }
  /**
   * 
   * @access public 
   * @return boolean 
   */
  function isGood()
  {
    return !$this->anyErrors();
  }
  /**
   * 
   * @access public 
   * @return boolean 
   */
  function anyWarnings()
  {
    return $this->_errorSeverity == EBAY_ERR_WARNING;
  }
  /**
   * Severity is set to the highest level
   * so if the Result Object has the warning-Level and
   * you set the severity to error, the Results severity will become also error-level
   * If the Result-Object is on error-level you can backchange to the warning-level
   * please call first with level = 0 to reset the severity and then set to warning-level
   * 
   * @access public 
   * @param number $level 
   * @return void 
   */
  function setSeverity($level)
  {
    switch ($level) {
      case EBAY_ERR_SUCCESS:
        // resetting the severity
        $this->_errorSeverity = EBAY_ERR_SUCCESS;
        break;
      case EBAY_ERR_ERROR:
        $this->_errorSeverity = EBAY_ERR_ERROR;
        break;
      case EBAY_ERR_WARNING:
        if ($this->_errorSeverity != EBAY_ERR_ERROR) {
          $this->_errorSeverity = EBAY_ERR_WARNING;
        };
        break;
    }
  }
  /**
   * 
   * @access public 
   * @param number $errCode 
   * @param string $errMessage 
   * @param define $errSeverity 
   * @return void 
   */
  function addError($errCode, $errMessage, $errSeverity)
  {
    $this->setSeverity($errSeverity);
    $this->_errors[] = array('LongMessage' => "$errMessage", 'Code' => "$errCode");
  }
  /**
   * 
   * @access public 
   * @return void 
   */
  function debugPrintErrors()
  {
    $c = count($this->_errors);
    for ($i = 0; $i < $c; $i++) {
      print_r("#" . $this->getErrorCode($i) . " : " . $this->getErrorMessage($i) . "<br>\r\n");
    }
  }
  /**
   * signals a break condition, so the retrieval process is aborted
   * 
   * @access public 
   * @return void 
   */
  function setUserBreak()
  {
    $this->_userBreak = true;
  }
  /**
   * returns true, if a break has to be handled
   * 
   * @access public 
   * @return void 
   */
  function hasUserBreak()
  {
    return $this->_userBreak;
  }
  /**
   * 
   * @access public 
   * @return number 
   */
  function getErrorCount()
  {
    return count($this->_errors);
  }
  /**
   * 
   * @access public 
   * @param string $tagName 
   * @return string 
   */
  function getXmlStructTagContent($tagName)
  {
    if (isset($this->_xmlTags[$tagName])) {
      return $this->_xmlValues[$this->_xmlTags[$tagName][0]]['value'];
    }else {
      return null;
    }
  }
  /**
   * 
   * @access public 
   * @param string $tagName 
   * @param boolean $includeSearchTag if set to true the data returned will include the tag which was search, normally you would just get the inner elements so pass false (which is the default).
   * @param  $ <unspecified> $searchBackward
   * @return array 
   */
  function getXmlStructResultFragment($tagName, $includeSearchTag = false, $searchBackward = false)
  {
    if ($searchBackward) {
      $max = count($this->_xmlTags[$tagName]);
      if ($max) {
        if ($includeSearchTag) {
          $offset = $this->_xmlTags[$tagName][$max - 2];
          $len = $this->_xmlTags[$tagName][$max -1] - $this->_xmlTags[$tagName][$max - 2] + 1;
        }else {
          $offset = $this->_xmlTags[$tagName][$max - 2] + 1;
          $len = $this->_xmlTags[$tagName][$max -1] - $this->_xmlTags[$tagName][$max - 2] - 1;
        }
      }
    }else {
      if ($includeSearchTag) {
        $offset = $this->_xmlTags[$tagName][0];
        $len = $this->_xmlTags[$tagName][1] - $this->_xmlTags[$tagName][0] + 1;
      }else {
        $offset = $this->_xmlTags[$tagName][0] + 1;
        $len = $this->_xmlTags[$tagName][1] - $this->_xmlTags[$tagName][0] - 1;
      }
    }
    return array_slice($this->_xmlValues, $offset, $len);
  }
  /**
   * 
   * @access public 
   * @return string 
   */
  function getToolkitVersion()
  {
    return "1.0.403.0";
  }
  /**
   * 
   * @access public 
   * @return void 
   */
  function EbatNs_Result()
  {
    // call to initialisation
    // (be sure to call this always on the actual class and prevent any overwriting)
    EbatNs_Result::_init();
    // insert code here...
  }
}

?>