<?php

class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
     public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_category_grid');
        $this->setDefaultSort('category_level');
        $this->setDefaultDir('asc');		
		$this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $model = Mage::getModel('magebid/import_category');
        $collection = $model->getCollection();
        $collection->addFieldToFilter('store','0');		    
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }
	
	

    protected function _prepareColumns()
    {
        $this->addColumn('category_id', array(
            'header'        => Mage::helper('magebid')->__('ID'),
            'filter_index'  => 'category_id',
            'index'         => 'category_id',
        ));

        $this->addColumn('category_level', array(
            'header'        => Mage::helper('magebid')->__('Level'),
            'filter_index'  => 'category_level',
            'index'         => 'category_level',
        ));
		
        $this->addColumn('category_name', array(
            'header'        => Mage::helper('magebid')->__('Name'),
            'filter_index'  => 'category_name',
            'index'         => 'category_name',
        ));
		
        $this->addColumn('category_parent_id', array(
            'header'        => Mage::helper('magebid')->__('Parent ID'),
            'filter_index'  => 'category_parent_id',
            'index'         => 'category_parent_id',
        ));							

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
       return false;
    }
	
    public function getGridUrl()
    {
        return $this->getUrl('*/*/categories', array('_current' => true));
    }		
}
?>
