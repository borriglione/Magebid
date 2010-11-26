<?php
/**
 * Mbid_Magebid_Model_Profile
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Profile extends Mage_Core_Model_Abstract
{
    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        $this->_init('magebid/profile');
    }	
	
    /**
     * Return Profile Collection with joined relations
     *
     * @return object
     */	     
	public function getCollection()
	{
		$collection = parent::getCollection();	
		$collection->joinFields();	
		return $collection;
	}	
	
    /**
     * Method creates an array with yes/no options for the new/edit-view
     *
     * @return array
     */	   	
	public function getYesNoTypes()
	{
		$yes_no_options = array(
				0 => array('value'=>0,'label'=>Mage::helper('magebid')->__('No')),
				1 => array('value'=>1,'label'=>Mage::helper('magebid')->__('Yes'))
				);
				
		array_unshift($yes_no_options, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please select --')));	
		
		return $yes_no_options;			
	}
	
    /**
     * Method creates an array with the possible listing_durations for the new/edit-view
     *
     * @return array
     */	 
	public function getDurationOptions()
	{
		$duration_options = array(
				array('value'=>'Days_3','label'=>Mage::helper('magebid')->__('%s Days',3)),
				array('value'=>'Days_5','label'=>Mage::helper('magebid')->__('%s Days',5)),
				array('value'=>'Days_7','label'=>Mage::helper('magebid')->__('%s Days',7)),
				array('value'=>'Days_10','label'=>Mage::helper('magebid')->__('%s Days',10)),
				array('value'=>'Days_30','label'=>Mage::helper('magebid')->__('%s Days',30)),
				array('value'=>'Days_60','label'=>Mage::helper('magebid')->__('%s Days',60)),	
				array('value'=>'Days_90','label'=>Mage::helper('magebid')->__('%s Days',90)),
				array('value'=>'GTC','label'=>Mage::helper('magebid')->__('Good Til Cancelled (GTC)')),											
				);
		array_unshift($duration_options, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please select --')));	
		
		return $duration_options;
	}
	
    /**
     * Method creates an array with the possible Hit Counter Styles for the new/edit-view
     *
     * @return array
     */	 
	public function getHitCounterStyles()
	{
		$hit_counter_options = array(
				array('value'=>'BasicStyle','label'=>Mage::helper('magebid')->__('BasicStyle')),
				array('value'=>'GreenLED','label'=>Mage::helper('magebid')->__('GreenLED')),
				array('value'=>'HiddenStyle','label'=>Mage::helper('magebid')->__('HiddenStyle')),
				array('value'=>'HonestyStyle','label'=>Mage::helper('magebid')->__('HonestyStyle')),
				array('value'=>'NoHitCounter','label'=>Mage::helper('magebid')->__('NoHitCounter')),
				array('value'=>'RetroStyle','label'=>Mage::helper('magebid')->__('RetroStyle'))
				);
		array_unshift($hit_counter_options, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please select --')));	
		
		return $hit_counter_options;					
	}	

    /**
     * Method creates an array with all profiles 
     * Used in the creation-process of an auction
     *
     * @return array
     */	 	
	public function getAllProfileOptions()
	{
		$collection = parent::getCollection();	
		$collection = $collection->toOptionArray();
		array_unshift($collection, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please select --')));
		return $collection;
	}	
	
    /**
     * Method creates an array with the possible Listing Enhancements for the new/edit-view
     *
     * @return array
     */	 	
	public function getListingEnhancements()
	{
		$listing_enhancement_options = array(
				array('value'=>'BasicUpgradePackBundle','label'=>Mage::helper('magebid')->__('BasicUpgradePackBundle')),
				array('value'=>'BoldTitle','label'=>Mage::helper('magebid')->__('BoldTitle')),
				array('value'=>'Border','label'=>Mage::helper('magebid')->__('Border')),
				array('value'=>'CustomCode','label'=>Mage::helper('magebid')->__('CustomCode')),
				array('value'=>'Featured','label'=>Mage::helper('magebid')->__('Featured')),
				array('value'=>'Highlight','label'=>Mage::helper('magebid')->__('Highlight')),
				array('value'=>'HomePageFeatured','label'=>Mage::helper('magebid')->__('HomePageFeatured')),
				array('value'=>'ProPackBundle','label'=>Mage::helper('magebid')->__('ProPackBundle')),
				array('value'=>'ProPackPlusBundle','label'=>Mage::helper('magebid')->__('ProPackPlusBundle')),
				array('value'=>'ValuePackBundle','label'=>Mage::helper('magebid')->__('ValuePackBundle')),				
				);
		array_unshift($listing_enhancement_options, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- None --')));

		return $listing_enhancement_options;		
	}
}
?>
