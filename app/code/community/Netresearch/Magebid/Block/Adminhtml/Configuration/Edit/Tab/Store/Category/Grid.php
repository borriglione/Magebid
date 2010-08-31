<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Store_Category_Grid
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Store_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_store_category_grid');
        $this->setDefaultSort('category_level');
        $this->setDefaultDir('asc');		
		$this->setUseAjax(true);
    }

    /**
     * Prepare Collection
     *
     * @return object
     */	
    protected function _prepareCollection()
    {
        $model = Mage::getModel('magebid/import_category');
        $collection = $model->getCollection();	
		$collection->addFieldToFilter('store','1');	    
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
        return $this->getUrl('*/*/storeCategories', array('_current' => true));
    }		
}
?>
