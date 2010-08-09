<?php

class Netresearch_Magebid_Block_Adminhtml_Log_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_module = 'magebid';
    protected $_model  = 'log';    
	
	public function __construct()
    {
        parent::__construct();
        $this->setId('magebidGrid');
        $this->setDefaultSort('date_created');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
        $model = Mage::getModel('magebid/log');
        $collection = $model->getCollection();		    
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }	    
    
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
    
    
    protected function _prepareMassaction()
    {
        
		$this->setMassactionIdField($this->_model.'_id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('magebid')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper($this->_module)->__('Are you sure?')
        ));	
		
        return $this;
    }	   

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $row->getMagebidLogId(),
        ));
    }
}
?>
