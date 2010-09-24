<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Catalog_Product_Grid
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    /**
     * Prepare Massaction
     *
     * @return object
     */	
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');
		
        $this->getMassactionBlock()->addItem('new_ebay_export', array(
             'label'=> Mage::helper('magebid')->__('Prepare for Ebay'),
             'url'  => $this->getUrl('magebid/adminhtml_export_main/new')
        ));		
		return $this;
    }	

    /**
     * Disable the RSS-Link and the Action-Column
     *
     * @return object
     */	
    protected function _prepareColumns()
    {
    	parent::_prepareColumns();
    	unset($this->_rssLists);
    	unset($this->_columns['action']);
    	return $this;
    }

    /**
     * Disable the row url
     *
     * @return boolean
     */	
    public function getRowUrl($row)
    {
        return false;
    }
}
?>
