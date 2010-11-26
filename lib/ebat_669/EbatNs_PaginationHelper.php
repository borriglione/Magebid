<?php
// $Id: EbatNs_PaginationHelper.php,v 1.2 2008-05-02 15:04:05 carsten Exp $
// $Log: EbatNs_PaginationHelper.php,v $
// Revision 1.2  2008-05-02 15:04:05  carsten
// Initial, PHP5
//
//
class EbatNs_PaginationHelper
{
    protected $_proxy;

    protected $_callname;

    protected $_request;

    protected $_responseElementToMerge;

    protected $_maxEntries;

    protected $_currentPage;

    protected $_receivedElements;

    protected $_accumulatedResponse;

    protected $_receivedMaxPages;

    protected $_bCountedByHandler;

    protected $_debug = 0;

    // if $responseElementToMerge is set to '__COUNT_BY_HANDLER' an attached handler HAS to count the elements
    // and inform the $EbatNs_ServiceProxy by calling ->incrementPaginationCounter();
    function __construct ($proxy, $callName, $request, $responseElementToMerge = '__COUNT_BY_HANDLER', $maxEntries = 200, $pageSize = 200, $initialPage = 1)
    {
        $this->_proxy = $proxy;
        $this->_callname = $callName;
        $this->_request = $request;
        
        if ($responseElementToMerge == '__COUNT_BY_HANDLER')
        {
            $this->_bCountedByHandler = true;
            $this->_responseElementToMerge = null;
        } else
        {
            $this->_responseElementToMerge = $responseElementToMerge;
            $this->_bCountedByHandler = false;
        }
        
        $this->_maxEntries = $maxEntries;
        
        $this->_currentPage = 0;
        $this->_receivedElements = 0;
        $this->_receivedMaxPages = - 1;
        
        $this->_accumulatedResponse = null;
        
        // add pagination infomation to the request
        $this->_request->Pagination = new PaginationType();
        
        $this->_request->Pagination->EntriesPerPage = $pageSize;
        $this->_request->Pagination->PageNumber = ($initialPage - 1);
    }

    function getNextPage ()
    {
        // important to have the data here !!!
        global $Facet_AckCodeType;
        
        $bFirst = false;
        if ($this->_currentPage == 0)
        {
            // prepare first call
            $bFirst = true;
        } 
        else
        {
            // break the operation if the maximum count is reached
            // 
            // $this->_maxEntries eq -1 will not stop till all data was downloaded !
            //
            if ($this->_maxEntries > 0)
            {
                if ($this->_bCountedByHandler)
                {
                    // echo "<br>checking (handler) " . $this->_proxy->getPaginationCounter() . " to " . $this->_maxEntries . "<br>";
                    if ($this->_proxy->getPaginationCounter() >= $this->_maxEntries)
                    {
                        // Break out getPaginationCounter() >= _maxEntries;
                        return false;
                    }
            } 
            else
            {
                // echo "<br>checking (attach-mode) " . $this->_proxy->getPaginationCounter() . " to " . $this->_maxEntries . "<br>";
                if (count($this->_accumulatedResponse) >=
                     $this->_maxEntries)
                    {
                        // Break out _accumulatedResponse >= _maxEntries
                        return false;
                }
            }
        }
        }
        
        $this->_request->Pagination->PageNumber ++;
        
        // calling the proxy method for this api-call
        $res = call_user_method($this->_callname, $this->_proxy, $this->_request);
        if ($bFirst)
        {
            $this->_accumulatedResponse = $res;
        }
        
        if ($res->Ack != $Facet_AckCodeType->Success)
        {
            // overwrite the response in case of an error
            $this->_accumulatedResponse->Ack = $res->Ack;
            if (is_array($this->_accumulatedResponse->Errors))
            {
                $this->_accumulatedResponse->Errors = array_merge($this->_accumulatedResponse->Errors, $res->Errors);
            } else
                $this->_accumulatedResponse->Errors = $res->Errors;
                
            // Break out, got an error
            return false;
        }
        
        if ($this->_bCountedByHandler)
        {
            $this->_receivedElements = $this->_proxy->getPaginationCounter();
        } else
        {
            if (is_array($res->{$this->_responseElementToMerge}))
                $this->_receivedElements += count($res->{$this->_responseElementToMerge});
        }
        
        $this->_receivedMaxPages = $res->PaginationResult->TotalNumberOfPages;
        $this->_currentPage = $res->PageNumber;
        
        if (! $bFirst && ! $this->_bCountedByHandler)
            $this->_accumulatedResponse->{$this->_responseElementToMerge} = array_merge($this->_accumulatedResponse->{$this->_responseElementToMerge}, $res->{$this->_responseElementToMerge});
        
        if ($this->_receivedMaxPages == 0 || ($this->_receivedMaxPages == $this->_currentPage))
        {
            // this was the final page returned from the API
            return false;
        }
        
        // ok, we have more pages
        return true;
    }

    function QueryAll ()
    {
        while ($this->getNextPage())
            ;
        
        return $this->_accumulatedResponse;
    }
}
?>