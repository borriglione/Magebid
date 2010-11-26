<?php
// $Id: EbatNs_ComplexType.php,v 1.6 2008-10-08 10:31:19 carsten Exp $
// $Log: EbatNs_ComplexType.php,v $
// Revision 1.6  2008-10-08 10:31:19  carsten
// changed the way the meta data is stored for schema objects. Now the information is helt in a static array (in EbatNs_ComplexType) for ALL schema classes.
// Beside changes in the Core and the ComplexType class this will also need a different way how the schema-information is stored within the constructors of all generated schema-classes.
//
// Revision 1.5  2008/07/09 11:51:20  michael
// switched back to get_class
//
// Revision 1.4  2008/07/09 11:41:50  michael
// improved type guessing for flattened array element names
//
// Revision 1.3  2008/05/04 15:24:03  carsten
// *** empty log message ***
//
// Revision 1.2  2008/05/02 15:04:05  carsten
// Initial, PHP5
//
//
require_once 'EbatNs_SimpleType.php';

class EbatNs_ComplexType extends EbatNs_SimpleType
{ 
	// an array of SimpleTypes / ComplexTypes  (child-elements)
	// now this static array will hold the complete schema information for any
	// element-class where an object is created !
	protected static $_elements = array();  
	// will define wheather the data is stored in the value-field (as a assoc array)
	// or either in Members of an object
	protected $_dataInValueArray = false;

	function __construct( $name, $nsURI )
	{
		self::$_elements[__CLASS__] = array();
	    parent::__construct($name, $nsURI);
	} 
	
	// will serialize the given value
	// and return XML-data.
	// give preserveNull = true to enforce serialization of values that evaluate to false (null or 0 or '')
	// we assume a value also as empty if the any child elements will not return any data.
	function serialize( $elementName, $value, $attributeValues, $preserveNull, $typeName, $dataConverter )
	{ 
		$ret = '';
		// lets decide where we are getting the data from
		if ( $this->_dataInValueArray )
		{
			$ret = '';
			foreach ( $value as $key => $data )
			{
				if ( isset( $data->attributeValues ) )
					$attributeValues = $data->attributeValues;
				else
					$attributeValues = null;

				if ( $data instanceof EbatNs_SimpleType )
				{
					$ret .= $data->serialize( $key, $data, $attributeValues, $preserveNull, null, $dataConverter );
				} 
				else
					$ret .= EbatNs_SimpleType::serialize( $key, $data, $attributeValues, $preserveNull, null, $dataConverter );
			} 
		} 
		else
		{
			if ( count( $this->getMetaDataElements() ) == 0 )
			{
				$ret = $this->value;
			} 
			else
				foreach ( $this->getMetaDataElements() as $childElementName => $childTypeInfo )
			{
				$childValue = $this->
				{
					$childElementName} ;
				if ( isset( $childTypeInfo['type'] ) )
					$childType = $childTypeInfo['type'];
				else
					$childType = null;

				if ( is_array( $childValue ) )
				{
					$needArraySurrounding = null;
					foreach ( $childValue as $arrayElementValue )
					{
						if ( isset( $arrayElementValue->attributeValues ) )
							$childAttributeValues = $arrayElementValue->attributeValues;
						else
							$childAttributeValues = null;

						if ( $childValue instanceof  EbatNs_SimpleType )
						{ 
							$ret .= $childValue->serialize( $childElementName, $arrayElementValue, $childAttributeValues, $preserveNull, $childType, $dataConverter ); 
						} 
						else
						{ 
							if (is_object($arrayElementValue))
							{
								// hack to guess the original element name out of
								// the class-name of the array-element
								if (!$childTypeInfo['array'])
								{
									list($questedName) = split('Type', get_class($arrayElementValue));
									$needArraySurrounding = $childElementName;	 
									$ret .= $arrayElementValue->serialize( $questedName, $arrayElementValue, $childAttributeValues, $preserveNull, $childType, $dataConverter ) ;
								}
								else
								{
									$ret .= $arrayElementValue->serialize( $childElementName, $arrayElementValue, $childAttributeValues, $preserveNull, $childType, $dataConverter );
								}
							}
							else
								$ret .= EbatNs_SimpleType::serialize( $childElementName, $arrayElementValue, $childAttributeValues, $preserveNull, $childType, $dataConverter );
						} 
					}
					
					if ($needArraySurrounding !== null)
					{
						$ret = '<' . $needArraySurrounding . '>' . $ret . '</' . $needArraySurrounding . '>';
					}
				}  
				else
				{
					if ( isset( $childValue->attributeValues ) )
						$childAttributeValues = $childValue->attributeValues;
					else
						$childAttributeValues = null;

					if ( $childValue instanceof EbatNs_SimpleType )
					{ 
						$ret .= $childValue->serialize( $childElementName, $childValue, $childAttributeValues, $preserveNull, $childType, $dataConverter ); 
					} 
					else
					{ 
						$ret .= EbatNs_SimpleType::serialize( $childElementName, $childValue, $childAttributeValues, $preserveNull, $childType, $dataConverter );
					} 
				} // plain
			} 
		} 
		$ret = '<' . $elementName . $this->_getAttributeString( $attributeValues ) . '>' . $ret . '</' . $elementName . '>';
		return $ret;
	} 

	/**
     * Do not use anymore
     *
     * @deprecated 
     */
    public function unsetMetaData($class = null)
    {
        if ($class === null)
            $class = get_class($this);
        parent::unsetMetaData();
        unset($this->_elements[$class]);
    }
    
    public function getMetaDataElements($class = null)
    {
       if ($class === null)
            $class = get_class($this);
        return self::$_elements[$class];
    }
    
    public function addMetaDataElement($elementName, $metaData, $class = null)
    {
        if ($class === null)
            $class = get_class($this);
        self::$_elements[$class][$elementName] = $metaData;        
    }
} 
?>