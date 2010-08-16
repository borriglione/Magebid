<?php
// $Id: EbatNs_ResponseError.php,v 1.2 2008-05-02 15:04:05 carsten Exp $
// $Log: EbatNs_ResponseError.php,v $
// Revision 1.2  2008-05-02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'AbstractResponseType.php';

class EbatNs_ResponseError extends AbstractResponseType
{

    function __construct ()
    {
        parent::__construct();
        $this->Errors = array();
        $this->Ack = 'Failure';
    }

    function raise ($msg, $code, $severity = 'Error', $errClass = 'SystemError')
    {
        $err = new ErrorType();
        $err->setErrorCode($code);
        $err->setSeverityCode($severity);
        $err->setLongMessage(htmlentities($msg));
        $err->setErrorClassification($errClass);
        $this->_reduceElement($err);
        
        $this->Errors[] = $err;
    }

    function getErrors ($index = false)
    {
        return $this->Errors;
    }

    function isGood ($onlyErrors = true)
    {
        if ($onlyErrors)
        {
            if (count($this->Errors))
                foreach ($this->Errors as $error)
                {
                    if ($error['severity'] ==
                         'Error')
                            return false;
                }
            return true;
        } else
            return (count($this->Errors) == 0);
    }

    protected function _reduceElement (& $element)
    {
        foreach (get_object_vars($element) as $member => $value)
            if ($member[0] == '_' || ($value === null))
                unset($element->{$member});
        return count(get_object_vars($element)) > 0;
    }
}
?>