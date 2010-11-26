<?php
// $Id: EbatNs_SimpleType.php,v 1.3 2008-10-02 13:53:19 carsten Exp $
// $Log: EbatNs_SimpleType.php,v $
// Revision 1.3  2008-10-02 13:53:19  carsten
// reopened generic access to all properties without getter/setter
//
// Revision 1.2  2008/05/02 15:04:05  carsten
// Initial, PHP5
//
//
class EbatNs_SimpleType
{ 
	// type-name
	protected $_typeName; 
	// namespace (prefix)
	protected $_ns; 
	// namespace (fullname)
	protected $_nsURI; 
	// array or not
	protected $_isArrayType = false; 
	// associative array of attribute-names
	public $_attributes = array(); 
	// values of attributes
	public $attributeValues = null; 
	// a plain value (in case of a simple-type)
	protected $value = null;

	function __construct( $typeName = 'string', $nsURI = 'http://www.w3.org/2001/XMLSchema' )
	{
		$this->_typeName = $typeName;
		$this->_nsURI = $nsURI;
	} 

	function _getAttributeString( $attributeValues )
	{
		$ret = '';
		if ( $attributeValues )
			foreach ( array_keys( $attributeValues ) as $key )
			$ret .= $key . '="' . $attributeValues[$key] . '" ';
		if ( !$ret )
			return '';
		else
			return ' ' . $ret;
	} 

	/**
	 * Set the value of an attribute on this object.
	 * as we got a name-clash with the attribute-class we choose this name
	 */
	function setTypeAttribute( $key, $value )
	{
		$this->attributeValues[$key] = $value;
	} 

	/**
	 * Get the value of an attribute on this object.
	 * as we got a name-clash with the attribute-class we choose this name
	 */
	function getTypeAttribute( $key )
	{
		return isset( $this->attributeValues[$key] ) ?
		$this->attributeValues[$key] :
		null;
	} 

	// set the value, as there is a name clash with the attribute-value class
	// we choose this name !
	function setTypeValue( $value )
	{
		$this->value = $value;
	} 

	// get the value, as there is a name clash with the attribute-value class
	// we choose this name !
	function getTypeValue()
	{
		return $this->value;
	} 
	
	// will serialize the given value
	// and return XML-data.
	// give preserveNull = true to enforce serialization of values that evaluate to false (null or 0 or '')
	function serialize( $elementName, $value, $attributeValues, $preserveNull, $typeName, $dataConverter )
	{
		if (isset($value))
		{
			if ($value || $preserveNull)
			{
				$ret = '<' . $elementName . $this->_getAttributeString( $attributeValues ) . '>';
				if ( $dataConverter )
					$value = $dataConverter->encodeData( $value, $typeName, $elementName );
				$ret .= $value;

				$ret .= '</' . $elementName . '>';

				return $ret;
			} 
			else
				return '<' . $elementName . '/>';
		} 
		else
		{
			return '';
		} 
	} 

    public function __setByKey($key, $value)
    {
        $this->{$key} = $value;
    }
    
    public function __addArray($key, $value)
    {
        $this->{$key}[] = $value;
    }
    
    public function __getByKey($key)
    {
        return $this->{$key};
    }
    
	public function __get($key)
    {
        return $this->{$key};
    }
    
	public function __set($key, $value)
    {
        $this->{$key} = $value;
    }
    
    public function reduceElement($noEmptyValues)
    {
        $thisObj = new ReflectionObject($this);
        if ($noEmptyValues)
		{
		    foreach ($thisObj->getProperties() as $property)
		    {
				$member = $property->getName();
		        $value  = $this->{$member}; 
		        if ($member[0] == '_' || ($value === null))
				    unset($this->{$member});
		    }
		}
		else
		{
		    foreach ($thisObj->getProperties() as $property)
		    {
				$member = $property->getName();
		        $value  = $this->{$member}; 
		        if ($member[0] == '_')
					unset($this->{$member});
		    }
		}
		$thisObj = new ReflectionObject($this);
		return (count($thisObj->getProperties()) > 0);
    }
    
    public function unsetMetaData()
    {
        unset($this->_attributes);
    }
    
    public function getMetaDataElements()
    {
        return null;
    }
    
    public function getMetaDataAttributes()
    {
        return $this->_attributes;
    }
    
    function __clone()
	{
		foreach(array_keys(get_object_vars($this)) as $oKey)
		{
			if (is_array($this->{$oKey}))
			{
				foreach(array_keys($this->{$oKey}) as $aKey)
				{
					if (is_object($this->{$oKey}[$aKey]))
					{
						$this->{$oKey}[$aKey] = clone $this->{$oKey}[$aKey];
					}
				}
			}

			if (is_object($this->{$oKey}))
			{
				$this->{$oKey} = clone $this->{$oKey};
			}
		}
	}
} 

?>