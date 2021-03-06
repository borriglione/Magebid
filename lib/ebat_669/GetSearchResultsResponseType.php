<?php
// autogenerated file 18.05.2010 12:34
// $Id: $
// $Log: $
//
//
require_once 'ExpansionArrayType.php';
require_once 'SpellingSuggestionType.php';
require_once 'AbstractResponseType.php';
require_once 'RelatedSearchKeywordArrayType.php';
require_once 'BuyingGuideDetailsType.php';
require_once 'CategoryArrayType.php';
require_once 'SearchResultItemArrayType.php';
require_once 'PaginationResultType.php';

/**
 * Response contains the item listings that have the specified keyword(s) in 
 * thetitle, sub-title, and (optionally) the description. If the request uses any 
 * ofthe optional filtering properties, the item listings returned are 
 * thosecontaining the keyword(s) and meeting the filter criteria. <br><br>Not 
 * applicable to Half.com. 
 *
 * @link http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/types/GetSearchResultsResponseType.html
 *
 */
class GetSearchResultsResponseType extends AbstractResponseType
{
	/**
	 * @var SearchResultItemArrayType
	 */
	protected $SearchResultItemArray;
	/**
	 * @var int
	 */
	protected $ItemsPerPage;
	/**
	 * @var int
	 */
	protected $PageNumber;
	/**
	 * @var boolean
	 */
	protected $HasMoreItems;
	/**
	 * @var PaginationResultType
	 */
	protected $PaginationResult;
	/**
	 * @var CategoryArrayType
	 */
	protected $CategoryArray;
	/**
	 * @var BuyingGuideDetailsType
	 */
	protected $BuyingGuideDetails;
	/**
	 * @var ExpansionArrayType
	 */
	protected $StoreExpansionArray;
	/**
	 * @var ExpansionArrayType
	 */
	protected $InternationalExpansionArray;
	/**
	 * @var ExpansionArrayType
	 */
	protected $FilterRemovedExpansionArray;
	/**
	 * @var ExpansionArrayType
	 */
	protected $AllCategoriesExpansionArray;
	/**
	 * @var SpellingSuggestionType
	 */
	protected $SpellingSuggestion;
	/**
	 * @var RelatedSearchKeywordArrayType
	 */
	protected $RelatedSearchKeywordArray;
	/**
	 * @var boolean
	 */
	protected $DuplicateItems;

	/**
	 * @return SearchResultItemArrayType
	 */
	function getSearchResultItemArray()
	{
		return $this->SearchResultItemArray;
	}
	/**
	 * @return void
	 * @param SearchResultItemArrayType $value 
	 */
	function setSearchResultItemArray($value)
	{
		$this->SearchResultItemArray = $value;
	}
	/**
	 * @return int
	 */
	function getItemsPerPage()
	{
		return $this->ItemsPerPage;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setItemsPerPage($value)
	{
		$this->ItemsPerPage = $value;
	}
	/**
	 * @return int
	 */
	function getPageNumber()
	{
		return $this->PageNumber;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setPageNumber($value)
	{
		$this->PageNumber = $value;
	}
	/**
	 * @return boolean
	 */
	function getHasMoreItems()
	{
		return $this->HasMoreItems;
	}
	/**
	 * @return void
	 * @param boolean $value 
	 */
	function setHasMoreItems($value)
	{
		$this->HasMoreItems = $value;
	}
	/**
	 * @return PaginationResultType
	 */
	function getPaginationResult()
	{
		return $this->PaginationResult;
	}
	/**
	 * @return void
	 * @param PaginationResultType $value 
	 */
	function setPaginationResult($value)
	{
		$this->PaginationResult = $value;
	}
	/**
	 * @return CategoryArrayType
	 */
	function getCategoryArray()
	{
		return $this->CategoryArray;
	}
	/**
	 * @return void
	 * @param CategoryArrayType $value 
	 */
	function setCategoryArray($value)
	{
		$this->CategoryArray = $value;
	}
	/**
	 * @return BuyingGuideDetailsType
	 */
	function getBuyingGuideDetails()
	{
		return $this->BuyingGuideDetails;
	}
	/**
	 * @return void
	 * @param BuyingGuideDetailsType $value 
	 */
	function setBuyingGuideDetails($value)
	{
		$this->BuyingGuideDetails = $value;
	}
	/**
	 * @return ExpansionArrayType
	 */
	function getStoreExpansionArray()
	{
		return $this->StoreExpansionArray;
	}
	/**
	 * @return void
	 * @param ExpansionArrayType $value 
	 */
	function setStoreExpansionArray($value)
	{
		$this->StoreExpansionArray = $value;
	}
	/**
	 * @return ExpansionArrayType
	 */
	function getInternationalExpansionArray()
	{
		return $this->InternationalExpansionArray;
	}
	/**
	 * @return void
	 * @param ExpansionArrayType $value 
	 */
	function setInternationalExpansionArray($value)
	{
		$this->InternationalExpansionArray = $value;
	}
	/**
	 * @return ExpansionArrayType
	 */
	function getFilterRemovedExpansionArray()
	{
		return $this->FilterRemovedExpansionArray;
	}
	/**
	 * @return void
	 * @param ExpansionArrayType $value 
	 */
	function setFilterRemovedExpansionArray($value)
	{
		$this->FilterRemovedExpansionArray = $value;
	}
	/**
	 * @return ExpansionArrayType
	 */
	function getAllCategoriesExpansionArray()
	{
		return $this->AllCategoriesExpansionArray;
	}
	/**
	 * @return void
	 * @param ExpansionArrayType $value 
	 */
	function setAllCategoriesExpansionArray($value)
	{
		$this->AllCategoriesExpansionArray = $value;
	}
	/**
	 * @return SpellingSuggestionType
	 */
	function getSpellingSuggestion()
	{
		return $this->SpellingSuggestion;
	}
	/**
	 * @return void
	 * @param SpellingSuggestionType $value 
	 */
	function setSpellingSuggestion($value)
	{
		$this->SpellingSuggestion = $value;
	}
	/**
	 * @return RelatedSearchKeywordArrayType
	 */
	function getRelatedSearchKeywordArray()
	{
		return $this->RelatedSearchKeywordArray;
	}
	/**
	 * @return void
	 * @param RelatedSearchKeywordArrayType $value 
	 */
	function setRelatedSearchKeywordArray($value)
	{
		$this->RelatedSearchKeywordArray = $value;
	}
	/**
	 * @return boolean
	 */
	function getDuplicateItems()
	{
		return $this->DuplicateItems;
	}
	/**
	 * @return void
	 * @param boolean $value 
	 */
	function setDuplicateItems($value)
	{
		$this->DuplicateItems = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('GetSearchResultsResponseType', 'urn:ebay:apis:eBLBaseComponents');
		if (!isset(self::$_elements[__CLASS__]))
				self::$_elements[__CLASS__] = array_merge(self::$_elements[get_parent_class()],
				array(
					'SearchResultItemArray' =>
					array(
						'required' => false,
						'type' => 'SearchResultItemArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'ItemsPerPage' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'PageNumber' =>
					array(
						'required' => false,
						'type' => 'int',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					),
					'HasMoreItems' =>
					array(
						'required' => true,
						'type' => 'boolean',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '1..1'
					),
					'PaginationResult' =>
					array(
						'required' => false,
						'type' => 'PaginationResultType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'CategoryArray' =>
					array(
						'required' => false,
						'type' => 'CategoryArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'BuyingGuideDetails' =>
					array(
						'required' => false,
						'type' => 'BuyingGuideDetailsType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'StoreExpansionArray' =>
					array(
						'required' => false,
						'type' => 'ExpansionArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'InternationalExpansionArray' =>
					array(
						'required' => false,
						'type' => 'ExpansionArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'FilterRemovedExpansionArray' =>
					array(
						'required' => false,
						'type' => 'ExpansionArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'AllCategoriesExpansionArray' =>
					array(
						'required' => false,
						'type' => 'ExpansionArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'SpellingSuggestion' =>
					array(
						'required' => false,
						'type' => 'SpellingSuggestionType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'RelatedSearchKeywordArray' =>
					array(
						'required' => false,
						'type' => 'RelatedSearchKeywordArrayType',
						'nsURI' => 'urn:ebay:apis:eBLBaseComponents',
						'array' => false,
						'cardinality' => '0..1'
					),
					'DuplicateItems' =>
					array(
						'required' => false,
						'type' => 'boolean',
						'nsURI' => 'http://www.w3.org/2001/XMLSchema',
						'array' => false,
						'cardinality' => '0..1'
					)
				));
	}
}
?>
