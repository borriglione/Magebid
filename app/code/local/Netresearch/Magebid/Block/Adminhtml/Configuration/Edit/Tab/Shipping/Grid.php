<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping_Grid
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Shipping_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_shipping_grid');
		$this->setUseAjax(true);
    }

    /**
     * Prepare Collection
     *
     * @return object
     */	
    protected function _prepareCollection()
    {
        $model = Mage::getModel('magebid/import_shipping');
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
        $this->addColumn('shipping_service', array(
            'header'        => Mage::helper('magebid')->__('Shipping Service'),
            'filter_index'  => 'shipping_service',
            'index'         => 'shipping_service',
        ));

        $this->addColumn('shipping_service_id', array(
            'header'        => Mage::helper('magebid')->__('Shipping Service Id'),
            'index'         => 'shipping_service_id',
			'filter_index'  => 'shipping_service_id',
        ));
		
        $this->addColumn('description', array(
            'header'        => Mage::helper('magebid')->__('Description'),
            'align'         => 'left',
            'filter_index'  => 'description',
            'index'         => 'description',
        ));		
		
        $this->addColumn('carrier', array(
            'header'        => Mage::helper('magebid')->__('Carrier'),
            'filter_index'  => 'carrier',
            'index'         => 'carrier',
        ));		
		
        $this->addColumn('international', array(
            'header'        => Mage::helper('magebid')->__('International'),
            'filter_index'  => 'international',
            'index'         => 'international',
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
        return $this->getUrl('*/*/shippings', array('_current' => true));
    }	
}
?>
