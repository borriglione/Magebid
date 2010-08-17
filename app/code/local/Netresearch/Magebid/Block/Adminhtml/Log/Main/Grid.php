<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Log_Main_Grid
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Log_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */		
	public function __construct()
    {
        parent::__construct();
        $this->setId('magebidGrid');
        $this->setDefaultSort('date_created');
        $this->setDefaultDir('desc');
    }

    /**
     * Prepare Collection
     *
     * @return object
     */	
    protected function _prepareCollection()
    {
        $model = Mage::getModel('magebid/log');
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
        $this->addColumn('magebid_log_id', array(
            'header'        => Mage::helper('magebid')->__('ID'),
            'align'         => 'right',
            'width'         => '50px',
            'filter_index'  => 'magebid_log_id',
            'index'         => 'magebid_log_id',
        ));

        $this->addColumn('type', array(
            'header'        => Mage::helper('magebid')->__('Type'),
            'align'         => 'left',
            'filter_index'  => 'type',
            'index'         => 'type',
        ));

         $this->addColumn('title', array(
            'header'        => Mage::helper('magebid')->__('Title'),
            'align'         => 'left',
            'filter_index'  => 'title',
            'index'         => 'title',
        ));       
        
        $this->addColumn('result', array(
            'header'        => Mage::helper('magebid')->__('Result'),
            'align'         => 'left',
            'filter_index'  => 'result',
            'index'         => 'result',
        ));             
        
        $this->addColumn('date_created', array(
            'header'        => Mage::helper('magebid')->__('Date Created'),
            'align'         => 'left',
            'filter_index'  => 'date_created',
            'index'         => 'date_created',
            'type'          => 'datetime',
        ));		

        return parent::_prepareColumns();
    }
    
    /**
     * Prepare Massaction
     *
     * @return object
     */	
    protected function _prepareMassaction()
    {
        
		$this->setMassactionIdField($this->_model.'_id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('magebid')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('magebid')->__('Are you sure?')
        ));	
		
        return $this;
    }	   

    /**
     * Prepare Edit-Row-Url
     *
     * @return string
     */	
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $row->getMagebidLogId(),
        ));
    }
}
?>
