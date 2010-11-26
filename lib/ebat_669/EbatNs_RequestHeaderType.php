<?php
// $Id: EbatNs_RequestHeaderType.php,v 1.3 2008-10-08 10:31:19 carsten Exp $
// $Log: EbatNs_RequestHeaderType.php,v $
// Revision 1.3  2008-10-08 10:31:19  carsten
// changed the way the meta data is stored for schema objects. Now the information is helt in a static array (in EbatNs_ComplexType) for ALL schema classes.
// Beside changes in the Core and the ComplexType class this will also need a different way how the schema-information is stored within the constructors of all generated schema-classes.
//
// Revision 1.2  2008/05/02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'EbatNs_RequesterCredentialType.php';

class EbatNs_RequestHeaderType extends EbatNs_ComplexType
{
    /**
     * @var EbatNs_RequesterCredentialType
     */
    protected $RequesterCredentials;

    function __construct ()
    {
        parent::__construct('EbatNs_RequestHeaderType', 'urn:ebay:apis:eBLBaseComponents');
        if (!isset(self::$_elements[__CLASS__]))
    		self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()], 
                array(
                'RequesterCredentials' => array('required' => true , 
                    'type' => 'EbatNs_RequesterCredentialType' , 
                    'nsURI' => 'http://www.w3.org/2001/XMLSchema')));
    }

    /**
     * @param EbatNs_RequesterCredentialType $RequesterCredentials
     */
    public function setRequesterCredentials ($requesterCredentials)
    {
        $this->RequesterCredentials = $requesterCredentials;
    }
}
?>