<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment_Grid
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Payment_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
