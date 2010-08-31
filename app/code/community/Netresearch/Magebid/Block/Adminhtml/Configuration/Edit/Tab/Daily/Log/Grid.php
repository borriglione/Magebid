<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Daily_Log_Grid
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Daily_Log_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */	
     public function __construct()
    {
        parent::__construct();
        $this->setId('configuration_daily_log_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('day');
        $this->setDefaultDir('desc');	       
    }

    /**
     * Prepare Collection
     *
     * @return object
     */	
    protected function _prepareCollection()
    {
        $model = Mage::getModel('magebid/daily_log');
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
        $this->addColumn('day', array(
            'header'        => Mage::helper('magebid')->__('Day'),
            'filter_index'  => 'day',
            'index'         => 'day',
        ));

        $this->addColumn('count', array(
            'header'        => Mage::helper('magebid')->__('Count'),
            'index'         => 'count',
			'filter_index'  => 'count',
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
        return $this->getUrl('*/*/dailyLog', array('_current' => true));
    }		
}
?>
