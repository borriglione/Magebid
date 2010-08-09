<?php

class Netresearch_Magebid_Block_Adminhtml_Transaction_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_module = 'magebid';
    protected $_model  = 'transaction';

    public function __construct()
    {
        parent::__construct();
        $this->setId('magebid_transaction_main_grid');
        $this->_controller = 'magebid';
        $this->setDefaultSort('date_created');
        $this->setDefaultDir('desc');		
    }

    protected function _prepareCollection()
    {
		$collection = Mage::getModel('magebid/transaction')->getCollection();		
        $this->setCollection($collection);
        parent::_prepareCollection();		
    }
	
    protected function _prepareMassaction()
    {
        
		$this->setMassactionIdField($this->_model.'_id');
        $this->getMassactionBlock()->setFormFieldName('id');

        //$this->getMassactionBlock()->addItem('update', array(
        //     'label'    => Mage::helper('adminhtml')->__('Update'),
        //     'url'      => $this->getUrl('*/*/massUpdate')
        //));	
		
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('adminhtml')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete')
        ));				
		
        return $this;
    }		
	
    protected function _prepareColumns()
    {
		$this->addColumn('ebay_transaction_id', array(
            'header'        => Mage::helper('magebid')->__('Transaction ID'),
            'align'         => 'left',
            'width'         => '150px',
            'filter_index'  => 'ebay_transaction_id',
            'index'         => 'ebay_transaction_id',
        ));

        $this->addColumn('ebay_item_id', array(
            'header'        => Mage::helper('magebid')->__('Auction ID'),
            'align'         => 'left',
            'filter_index'  => 'ebay_item_id',
            'index'         => 'ebay_item_id',
        ));
        
        $this->addColumn('ebay_order_id', array(
            'header'        => Mage::helper('magebid')->__('eBay Order ID'),
            'align'         => 'left',
            'filter_index'  => 'ebay_order_id',
            'index'         => 'ebay_order_id',
        ));

        $this->addColumn('order_id', array(
            'header'        => Mage::helper('magebid')->__('Magento Order ID'),
            'align'         => 'left',
            'filter_index'  => 'order_id',
            'index'         => 'order_id',
        ));        
		
		/*
		$this->addColumn('name', array(
            'header'        => Mage::helper('magebid')->__('Status'),
            'align'         => 'left',
            'width'         => '150px',
            'filter_index'  => 'name',
            'index'         => 'name',
        ));	*/		
		
        $this->addColumn('checkout_status', array(
            'header'        => Mage::helper('magebid')->__('Checkout Status'),
            'align'         => 'left',
            'filter_index'  => 'checkout_status',
            'index'         => 'checkout_status',
        ));		
		
        $this->addColumn('complete_status', array(
            'header'        => Mage::helper('magebid')->__('Complete'),
            'align'         => 'left',
            'filter_index'  => 'complete_status',
            'index'         => 'complete_status',
        ));		
		
        $this->addColumn('	quantity', array(
            'header'        => Mage::helper('magebid')->__('Quantity'),
            'align'         => 'left',
            'filter_index'  => 'quantity',
            'index'         => 'quantity',
        ));							
		
        $this->addColumn('total_amount', array(
            'header'        => Mage::helper('magebid')->__('Total Amount'),
            'align'         => 'left',
            'filter_index'  => 'total_amount',
            'index'         => 'total_amount',
        ));		

		
        $this->addColumn('buyer_email', array(
            'header'        => Mage::helper('magebid')->__('Buyer eMail'),
            'align'         => 'left',
            'filter_index'  => 'buyer_email',
            'index'         => 'buyer_email',
        ));	

        $this->addColumn('date_created', array(
            'header'        => Mage::helper('magebid')->__('Sold at'),
            'align'         => 'left',
			'type'			=> 'datetime',
            'filter_index'  => 'date_created',
            'index'         => 'date_created',
        ));	

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
       return $this->getUrl('*/*/edit', array(
            'id' => $row->getMagebidTransactionId(),
        ));
    }
	
	
    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }	
}
?>
