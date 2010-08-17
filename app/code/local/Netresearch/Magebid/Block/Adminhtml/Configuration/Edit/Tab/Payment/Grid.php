<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment_Grid
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_payment_grid');
        $this->setUseAjax(true);
    }
    
    /**
     * Prepare Collection
     *
     * @return object
     */	
    protected function _prepareCollection()
    {
        $model = Mage::getModel('magebid/import_payment');
        $collection = $model->getCollection();		    
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }
	
    /**
     * Prepare Columns
     *
     * @return object
     */	
    protected function _prepareColumns()
    {
        $this->addColumn('code', array(
            'header'        => Mage::helper('magebid')->__('Code'),
            'filter_index'  => 'code',
            'index'         => 'code',
        ));

        $this->addColumn('description', array(
            'header'        => Mage::helper('magebid')->__('Description'),
            'index'         => 'description',
			'filter_index'  => 'description',
        ));					

        return parent::_prepareColumns();
    }
    
    /**
     * Disable Row-Edit-Url
     *
     * @return boolean
     */	
    public function getRowUrl($row)
    {
       return false;
    }
	
    /**
     * Return Grid Url
     *
     * @return string
     */	
    public function getGridUrl()
    {
        return $this->getUrl('*/*/payments', array('_current' => true));
    }		
}
?>
