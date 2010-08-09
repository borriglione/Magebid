<?php 
// $Id: EbatNs_LegacyMapper.php,v 1.2 2008/05/02 15:04:05 carsten Exp $
// $Log: EbatNs_LegacyMapper.php,v $
// Revision 1.2  2008/05/02 15:04:05  carsten
// Initial, PHP5
//
//
/*
	- Only assignments are allowed (=)
	- Local vars are enclosed in []
	- Any expression might start with / to access the destination object
	- 
	
	local var [last] is set to $dest->SalesTax
		if SalesTax does not exist it will be created with the given type.
	[last]=/SalesTax|new:CategoryType

	local var [last] is set to $dest->SalesTax
		if SalesTax does not exist [last] will be null and operation will 
		return.
	[last]=/SalesTax|exist
	
	The element of local object is assigned a literal constant (e.g. $last->Element = 'Const')
	[last]/Element = Const | "My Value"

	The same, but the local object is assumed as a XsdType with an attribute	
	[last]/@Attribute=Const
	
	$dest->SalesTax is set to the reference of local var [last]
	/SalesTax=[last]

	$dest->SalesTax[] is set to the reference of local var [last]
	
	/()SalesTax=[last]

	$dest->SalesTax[index] is set. index will be calculated by the data with index 0 (or $data['myvar']
	/({0})SalesTax=[last]
	/({myvar})SalesTax=[last]
	
*/

/**
 * EbatNs_MapExpression
 * 
 * @package EbatNs
 * @author Carsten Harnisch 
 * @copyright Copyright (c) 2005, IntradeSys Limited
 * @version $Id: EbatNs_LegacyMapper.php,v 1.2 2008/05/02 15:04:05 carsten Exp $
 * @access public 
 */
class EbatNs_MapExpression
{
	protected $_expression;
	protected $_mapper;

	/**
	 * EbatNs_MapExpression::EbatNs_MapExpression()
	 * 
	 * @param mixed $mapper 
	 * @param mixed $expression 
	 * @return 
	 */
	function EbatNs_MapExpression(&$mapper, $expression)
	{
		$this->_mapper = &$mapper;
		$this->_expression = $expression;
	} 

	/**
	 * EbatNs_MapExpression::evalExpression()
	 * 
	 * @return 
	 */
	function &evalExpression()
	{ 
		// echo "evalExpression " . $this->_expression . "<br>";
		if ($this->_expression[0] == "[")
		{
			if (strstr($this->_expression, '/') !== false)
			{ 
				// an expression like [xxx]/element
				// or [xxx]/element|*type
				list($localname, $element) = explode('/', $this->_expression);
				$localname = trim($localname, "[]");
				$t = &$this->_mapper->_getLocal($localname);

				if (!$t)
				{ 
					// we could not the local var
					// so this is an error !
					return null;
				} 

				$pieces = explode("|", $element);
				$creationType = null;
				if (count($pieces) == 1)
				{
					$memberName = $pieces[0];
					$typename = null;
				} 
				else
				{
					$memberName = $pieces[0];
					$creationType = $pieces[1];

					if ($creationType[0] == '*')
						$typename = substr($creationType, 1);
					else
						$typename = 'stdClass';
				} 
				// echo "memberName $memberName <br>";
				// is this an index access ?
				if ($memberName[0] == "(")
				{
					$isIndexAccess = true;
					$accessIndex = $this->_parseIndex($memberName); 
					// echo "indexAccess $memberName [ $accessIndex ] ($typename) <br>";
					// print_r($t);
					// die("STOP");
					if ($accessIndex)
					{ 
						// die("STOP");
						if (isset($t->
								{
									$memberName} 
								[$accessIndex]))
						$target = $target = &$t->
						{
							$memberName} 
						[$accessIndex];
						else
						{ 
							// echo "indexAccess NOT THERE $memberName [ $accessIndex ] ($typename)<br>";
							// die("STOP");
							$target = null;
						} 
					} 
					else
					{ 
						// echo "indexAccess generic() $memberName [ $accessIndex ] <br>";
						// an generic index will create an new entry anyway
						$target = null;
					} 
				} 
				else
				{
					$isIndexAccess = false;
					$target = &$t->
					{
						$memberName} ;
				} 

				if (!$target && $typename)
				{
					$this->_mapper->includeType($typename);

					if ($isIndexAccess)
					{
						$t->
						{
							$memberName} 
						[$accessIndex] = &new $typename;
						$target = &$t->
						{
							$memberName} 
						[$accessIndex]; 
						// echo "indexAccess CREATED new $typename $memberName [ $accessIndex ] as <br>";
						// print_r($t);
						// die("STOP");
						// echo "<hr>";
					} 
					else
					{
						$t->
						{
							$memberName} = &new $typename;
						$target = &$t->
						{
							$memberName} ;
					} 
				} 

				return $target; 
				// echo "Eval Return : <br>";
				// print_r($t);
				// echo "<hr>";
			} 
			else
			{ 
				// plain local object  like [xxx]
				$localname = trim($this->_expression, "[]");
				$t = $this->_mapper->_getLocal($localname);

				if ($this->_expression == "[sd]")
				{ 
					// echo "Eval Return : <br>";
					// print_r($t);
					// echo "<hr>";
				} 
				return $t;
			} 
		} elseif ($this->_expression[0] == "{")
		{
			$datakey = trim($this->_expression, "{}");
			$t = &$this->_mapper->getData($datakey); 
			// echo "Eval Return : <br>";
			// print_r($t);
			// echo "<hr>";
			return $t;
		} elseif ($this->_expression[0] == "/")
		{
			$pieces = explode("|", substr($this->_expression, 1));
			$creationType = null;
			if (count($pieces) == 1)
				$creationType = $pieces[0];
			else
			{
				$targetName = $pieces[0];

				$t = &$this->_mapper->getTarget($targetName);
				if (!$t)
				{
					$creationType = $pieces[1];
				} 
			} 

			if ($creationType[0] == '*')
			{
				$typename = substr($creationType, 1);
				$this->_mapper->includeType($typename);
				$t = &new $typename;
			} 

			return $t;
		} 
		else
		{ 
			// echo "Return Plain<br>";
			return $this->_expression;
		} 
		echo "ERROR";
	} 

	/**
	 * EbatNs_MapExpression::_parseIndex()
	 * 
	 * @param mixed $name 
	 * @return 
	 */
	function _parseIndex(&$name)
	{
		list($tmpIndex, $name) = explode(")", $name);
		$tmpIndex = trim($tmpIndex, "(");
		if ($tmpIndex == "")
			return null;
		else
		{
			if ($tmpIndex[0] == "{")
			{
				$tmpIndex = trim($tmpIndex, "{}");
				$tmpIndex = $this->_mapper->getData($tmpIndex);
			} 
			return $tmpIndex;
		} 
	} 
} 

/**
 * EbatNs_MapTarget
 * 
 * @package EbatNs
 * @author Carsten Harnisch 
 * @copyright Copyright (c) 2005, IntradeSys Limited
 * @version $Id: EbatNs_LegacyMapper.php,v 1.2 2008/05/02 15:04:05 carsten Exp $
 * @access public 
 */
class EbatNs_MapTarget
{
	protected $_mapper;

	protected $_targetObject;

	protected $_targetName;
	protected $_targetIsArray;
	protected $_targetIndex;

	protected $_targetIsLocal;
	protected $_localName;

	/**
	 * EbatNs_MapTarget::EbatNs_MapTarget()
	 * 
	 * @param mixed $mapper 
	 * @param mixed $target 
	 * @return 
	 */
	function EbatNs_MapTarget(&$mapper, $target)
	{
		$this->_mapper = &$mapper;
		$this->parse($target);
	} 

	/**
	 * EbatNs_MapTarget::setTarget()
	 * 
	 * @param mixed $value 
	 * @return 
	 */
	function setTarget(&$value)
	{ 
		// echo "setTarget <br>";
		// print_r($this);
		if ($this->_targetIsLocal)
		{ 
			// echo "setTarget local $this->_localName $this->_targetName is_array: $this->_targetIsArray index: $this->_targetIndex<br>";
			if (!$this->_targetName)
			{ 
				// echo "setTarget <br>";
				$mapper = &$this->_mapper;
				$mapper->_setLocal($this->_localName, $value);
			} 
			else
			{
				$mapper = &$this->_mapper; 
				// print_r($this->_mapper);
				$this->_targetObject = &$mapper->_getLocal($this->_localName);
				$targetObject = &$this->_targetObject; 
				// echo "TargetObject <br>";
				// print_r($targetObject);
				if ($this->_targetIsArray)
				{
					if ($this->_targetIndex)
						$targetObject->
					{
						$this->_targetName} 
					[$this->_targetIndex] = &$value;
					else
						$targetObject->
					{
						$this->_targetName} 
					[] = &$value;
				} 
				else
				{
					if ($this->_targetName[0] == "@")
					{
						$targetObject->_attributeValues[substr($this->_targetName, 1)] = $value; 
						// print_r($targetObject);
						// die("123");
					} 
					else
					{ 
						// echo "$this->_targetName <br>";
						$targetObject->
						{
							$this->_targetName} = &$value;
					} 
				} 

				$mapper->_setLocal($this->_localName, $targetObject);
			} 
		} 
		else
		{
			$mapper = &$this->_mapper; 
			// echo "Before mapper->_setTarget <br>";
			// print_r($mapper->_destObject);
			$mapper->_setTarget($this->_targetName, $value, $this->_targetIsArray, $this->_targetIndex);
		} 

		return true;
	} 

	/**
	 * EbatNs_MapTarget::_parseIndex()
	 * 
	 * @param mixed $name 
	 * @return 
	 */
	function _parseIndex(&$name)
	{
		list($tmpIndex, $name) = explode(")", $name);
		$tmpIndex = trim($tmpIndex, "(");
		if ($tmpIndex == "")
			return null;
		else
		{
			if ($tmpIndex[0] == "{")
			{
				$tmpIndex = trim($tmpIndex, "{}");
				$tmpIndex = $this->_mapper->getData($tmpIndex);
			} 
			return $tmpIndex;
		} 
	} 

	/**
	 * EbatNs_MapTarget::parse()
	 * 
	 * @param mixed $target 
	 * @return 
	 */
	function parse($target)
	{
		$this->_targetName = $target;

		if ($target[0] == '/')
		{
			$this->_targetIsLocal = false;
			list($dummy, $this->_targetName) = explode("/", $target);

			if ($this->_targetName[0] == "(")
			{
				$this->_targetIsArray = true;
				$this->_targetIndex = $this->_parseIndex($this->_targetName);
			} 
			else
			{
				$this->_targetIsArray = false;
				$this->_targetIndex = null;
			} 
			// echo "Target is destination : $target $this->_targetName IsArray: $this->_targetIsArray Index: $this->_targetIndex<br>";
		} 
		else
		{
			$this->_targetIsLocal = true;
			list($dummy, $this->_targetName) = explode("/", $target);

			if ($this->_targetName[0] == "(")
			{
				$this->_targetIsArray = true;
				$this->_targetIndex = $this->_parseIndex($this->_targetName);
				$this->_targetName = trim($this->_targetName, "()");
			} 
			else
			{
				$this->_targetIsArray = false;
				$this->_targetIndex = null;
			} 

			list($targetName, $dummy) = explode("/", $target);
			$this->_localName = trim($targetName, "[]"); 
			// echo "Target is local $this->_localName $this->_targetName IsArray: $this->_targetIsArray Index: $this->_targetIndex<br>";
		} 
		// echo "need Parse target " . $target . "<br>";
	} 
} 

/**
 * EbatNs_MapMapping
 * 
 * @package easylister
 * @author michael 
 * @copyright Copyright (c) 2005
 * @version $Id: EbatNs_LegacyMapper.php,v 1.2 2008/05/02 15:04:05 carsten Exp $
 * @access public 
 */
class EbatNs_MapMapping
{
	protected $_EbatNs_MapTarget;
	protected $_EbatNs_MapExpression;
	protected $_mapper;

	/**
	 * EbatNs_MapMapping::EbatNs_MapMapping()
	 * 
	 * @param mixed $mapper 
	 * @param mixed $mapping 
	 * @return 
	 */
	function __construct($mapper, $mapping)
	{
		$this->_valueMap = $valueMap;
		$this->_mapper = &$mapper;
		$this->parse($mapping);
	} 

	/**
	 * EbatNs_MapMapping::map()
	 * 
	 * @return 
	 */
	function map()
	{
		$this->_EbatNs_MapTarget->setTarget($this->_EbatNs_MapExpression->evalExpression());
		return true;
	} 

	/**
	 * EbatNs_MapMapping::parse()
	 * 
	 * @param mixed $mapping 
	 * @return 
	 */
	function parse($mapping)
	{ 
		// empty or comment line
		if ($mapping == '' || $mapping[0] == ';')
			return;

		list($target, $expression) = explode('=', $mapping);
		$mapper = $this->_mapper;
		$this->_EbatNs_MapExpression = new EbatNs_MapExpression($mapper, $expression);
		$this->_EbatNs_MapTarget = new EbatNs_MapTarget($mapper, $target);
	} 
} 

/**
 * EbatNs_LegacyMapper
 * 
 * @package easylister
 * @author michael 
 * @copyright Copyright (c) 2005
 * @version $Id: EbatNs_LegacyMapper.php,v 1.2 2008/05/02 15:04:05 carsten Exp $
 * @access public 
 */
class EbatNs_LegacyMapper
{
	protected $_mappings;
	protected $_src;
	protected $_data;

	protected $_destObject;

	protected $_locals = null;
	protected $_valueMap;
	protected $_isValid = false;
	

	/**
	 * EbatNs_LegacyMapper::EbatNs_LegacyMapper()
	 * 
	 * @param mixed $mapping 
	 * @param mixed $destObject 
	 * @param mixed $data 
	 * @param mixed $valueMapString 
	 * @param mixed $defaultData 
	 * @return 
	 */
	function __construct($mapping, $destObject, $data, $valueMapString, $defaultData = null)
	{
		$this->_destObject = $destObject;
		if (is_array($data))
			$this->_data = $data;
		else
			$this->_data[] = $data;

		if ($defaultData)
			$this->setDefaults($defaultData);

		if ($valueMapString)
			$this->parseValueMap($valueMapString);

		$this->_isValid = $this->Parse($mapping);
	} 

	/**
	 * EbatNs_LegacyMapper::parseValueMap()
	 * 
	 * @param mixed $valueMapString 
	 * @return 
	 */
	function parseValueMap($valueMapString)
	{
		$this->_valueMap = null;
		$parts = explode("|", $valueMapString);

		foreach ($parts as $part)
		{
			list($key, $value) = explode("=", $part);
			$this->_valueMap[$key] = $value;
		} 
	} 

	/**
	 * EbatNs_LegacyMapper::Parse()
	 * 
	 * @param mixed $mapping 
	 * @return 
	 */
	function Parse($mapping)
	{
		$mapping = str_replace("\r\n", "\n", $mapping);
		$lines = explode("\n", $mapping);
		$this->_mappings = null;

		$thisObject = &$this;
		foreach ($lines as $line)
		{
			if ($line == '' || $line[0] == ';')
				continue;
			if (trim($line))
			{
				$aMapLine = new EbatNs_MapMapping($thisObject, $line);
				$this->_mappings[] = $aMapLine;
			} 
		} 

		return count($this->_mappings);
	} 

	/**
	 * EbatNs_LegacyMapper::Map()
	 * 
	 * @return 
	 */
	function Map()
	{
		if (!$this->_isValid)
			return; 
		foreach($this->_mappings as $mapping)
		{
			if (!$mapping->map())
				break;
		} 
	} 

	/**
	 * EbatNs_LegacyMapper::_setLocal()
	 * 
	 * @param mixed $key 
	 * @param mixed $value 
	 * @return 
	 */
	function _setLocal($key, &$value)
	{ 
		$this->_locals[$key] = &$value;
	} 

	/**
	 * EbatNs_LegacyMapper::_getLocal()
	 * 
	 * @param mixed $key 
	 * @return 
	 */
	function _getLocal($key)
	{ 
		return $this->_locals[$key];
	} 

	/**
	 * EbatNs_LegacyMapper::_setTarget()
	 * 
	 * @param mixed $targetName 
	 * @param mixed $value 
	 * @param mixed $isArray 
	 * @param mixed $index 
	 * @return 
	 */
	function _setTarget($targetName, &$value, $isArray = false, $index = null)
	{ 
		$dest = &$this->_destObject;

		if ($isArray)
		{
			if ($index)
				$dest->{$targetName}[$index] = $value;
			else
				$dest->{$targetName}[] = $value;
		} 
		else
		{
			if ($targetName[0] == "@")
				$dest->_attributeValues[substr($targetName, 1)] = $value;
			else
				$dest->{$targetName} = $value;
		} 
	} 

	/**
	 * EbatNs_LegacyMapper::getTarget()
	 * 
	 * @param mixed $name 
	 * @param mixed $index 
	 * @return 
	 */
	function &getTarget($name, $index = null)
	{ 
		$dest = $this->_destObject;

		if (isset($dest->{$name}))
		{
			if ($index)
				return $dest->{$name}[$index];
			else
				return $dest->{$name} ;
		} 
		else
			return null;
	} 

	/**
	 * EbatNs_LegacyMapper::getData()
	 * 
	 * @param mixed $indexKey 
	 * @return 
	 */
	function getData($indexKey)
	{
		$pieces = explode(":", $indexKey);
		if (count($pieces) == 1)
			return $this->_data[$indexKey];
		else
			return $this->_call_data_function($pieces[0], $this->_data[$pieces[1]]);
	} 

	/**
	 * EbatNs_LegacyMapper::includeType()
	 * 
	 * @param mixed $typeName 
	 * @return 
	 */
	function includeType($typeName)
	{
		if (!class_exists($typeName))
			require_once $typeName . '.php';
	} 

	/**
	 * EbatNs_LegacyMapper::_call_data_function()
	 * 
	 * @param mixed $funcName 
	 * @param mixed $arg 
	 * @return 
	 */
	function _call_data_function($funcName, $arg)
	{
		switch ($funcName)
		{
			case 'utf8_encode':
			case 'utf8encode':
				return utf8_encode($arg);
			case 'legacy-map':
			case 'mapped-options':
				return $this->mapValue($arg);
			case 'bool':
			case 'boolean':
				return $this->SoapBoolean($arg);

			case 'cdata': 
			// return '<![CDATA[' . $arg . ']]>';
			default:
				return $arg;
		} 
	} 

	/**
	 * EbatNs_LegacyMapper::mapValue()
	 * 
	 * @param mixed $arg 
	 * @return 
	 */
	function mapValue($arg)
	{
		if (isset($this->_valueMap[$arg]))
			return $this->_valueMap[$arg];
		else
			return $arg;
	} 

	/**
	 * EbatNs_LegacyMapper::setDefaults()
	 * 
	 * @param mixed $arrayData 
	 * @return 
	 */
	function setDefaults($arrayData)
	{
		$this->_data = array_merge($this->_data, $arrayData);
	} 

	/**
	 * EbatNs_LegacyMapper::SoapBoolean()
	 * 
	 * @param mixed $value 
	 * @return 
	 */
	function SoapBoolean($value)
	{
		if (is_numeric($value) || is_bool($value))
		{
			if ($value)
				return 'true';
			else
				return 'false';
		} 
		else
			return $value;
	} 
} 
?>