<?php
class Netresearch_Magebid_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected function _prepareMassaction()
    {
		parent::_prepareMassaction();
		
        $this->getMassactionBlock()->addItem('new_ebay_export', array(
             'label'=> Mage::helper('magebid')->__('Prepare for Ebay'),
             'url'  => $this->getUrl('magebid/adminhtml_export_main/new')
        ));		
		return $this;
    }	
}
?>
