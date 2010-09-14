<?php
/**
 * Mbid_Magebid_Model_Templates
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Templates extends Mage_Core_Model_Abstract
{

    /**
     * Construct
     *
     * @return void
     */	
    protected function _construct()
    {
        $this->_init('magebid/templates');	
    }

    /**
     * set created or modified date before item will be saved
     *
     * @return void
     */	
    protected function _beforeSave()
    {		
		//if template is new
		if (!$this->getId())
		{
			$this->setData('date_created', date('Y-m-d H:i:s'));     
		}
		else //if template is already existing
		{
			$this->setData('date_modified', date('Y-m-d H:i:s'));
		}
    }	
	
    /**
    * Return possible differemt template types in Magebid
    *
    * @return array
    */	   
	public function getTemplateTypes()
	{
		return array(
		0 => array('value'=>'header','label'=>Mage::helper('magebid')->__('Header')),
		1 => array('value'=>'footer','label'=>Mage::helper('magebid')->__('Footer')),
		2 => array('value'=>'main','label'=>Mage::helper('magebid')->__('Main template'))
		);
	}

    /**
    * Return differemt templates
    *
    * @param string $template_type Template type can be header,footer or main
    *
    * @return array
    */	 	
	function getAllTemplatesOptions($template_type = '')
	{
		$collection = parent::getCollection();	
		if ($template_type!='') $collection->addFieldToFilter('content_type',$template_type);	 
		$collection = $collection->toOptionArray();
		array_unshift($collection, array('value'=>'', 'label'=>Mage::helper('magebid')->__('-- Please Select --')));
		return $collection;
	}		
}
?>
