<?php
// $Id: EbatNs_FacetType.php,v 1.2 2008-05-02 15:04:05 carsten Exp $
// $Log: EbatNs_FacetType.php,v $
// Revision 1.2  2008-05-02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'EbatNs_SimpleType.php';

class EbatNs_FacetType extends EbatNs_SimpleType
{
    function __construct ($name, $nsURI)
    {
        parent::__construct($name, $nsURI);
    }
    
    /**
     * Just for a compatibility issue we mimik the 
     * PHP4 access via a property. Anyway the return is not
     * checked on valid input.
     *
     * @param string $name
     * @return string
     */
    function __get($name)
    {
        trigger_error("Property Style access to FacetTypes is deprecated and replaced by constants in PHP5.", E_USER_NOTICE);
        return $name;
    }
}
?>