<?php

class Netresearch_Magebid_Block_Adminhtml_Auction_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_module = 'magebid';
    protected $_model  = 'auction';

    public function __construct()
    {
        parent::__construct();
        $this->setId('magebidAuctionList');
        $this->setDefaultSort('date_created');
        $this->setDefaultDir('desc');
    }

    protected function _prepareCollection()
    {
		$collection = Mage::getModel('magebid/auction')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
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
        
        //$this->getMassactionBlock()->addItem('update', array(
        //      'label'    => Mage::helper('magebid')->__('Update'),
        //      'url'      => $this->getUrl('*/*/massUpdate')
        // ));        
		
        $this->getMassactionBlock()->addItem('export', array(
             'label'    => Mage::helper('magebid')->__('Export to Ebay'),
             'url'      => $this->getUrl('*/*/massExport')
        ));		
		
        $this->getMassactionBlock()->addItem('end', array(
             'label'    => Mage::helper('magebid')->__('End Items'),
             'url'      => $this->getUrl('*/*/massEndItems'),
			 'confirm'  => Mage::helper($this->_module)->__('Are you sure?')
        ));				
		
        return $this;
    }	

    protected function _prepareColumns()
    {

        $this->addColumn('magebid_auction_id', array(
            'header'        => Mage::helper('magebid')->__('Id'),
            'align'         => 'left',
            'filter_index'  => 'magebid_auction_id',
            'index'         => 'magebid_auction_id',
        ));

        $this->addColumn('ebay_item_id', array(
            'header'        => Mage::helper('magebid')->__('eBay Item ID'),
            'align'         => 'left',
            'filter_index'  => 'ebay_item_id',
            'index'         => 'ebay_item_id',
        ));

        $this->addColumn('product_name', array(
            'header'        => Mage::helper('magebid')->__('Auction title'),
            'align'         => 'left',
            'index'         => 'auction_name',
            'type'          => 'text',
            'truncate'      => 20,
            'escape'        => true,
        ));
		
		//Mage::debug(Mage::getSingleton('magebid/auction')->getEbayStatusOptions());
        $this->addColumn('status_name', array(
            'header'        => Mage::helper('magebid')->__('Status'),
            'index'         => 'status_name',
			'type'			=> 'text',
			//'type'     		=> 'options',
			//'options'   	=> Mage::getSingleton('magebid/auction')->getEbayStatusOptions(),
        ));		
		
        $this->addColumn('quantity', array(
            'header'        => Mage::helper('magebid')->__('Quantity'),
            'align'         => 'left',
            'index'         => 'quantity',
            'type'          => 'text',
			'width'         => '40px',
        ));		
		
        $this->addColumn('quantity_sold', array(
            'header'        => Mage::helper('magebid')->__('Sold'),
            'align'         => 'left',
            'index'         => 'quantity_sold',
            'type'          => 'text',
        ));			        
		
		$store = $this->_getStore();
		
        $this->addColumn('price_now', array(
            'header'        => Mage::helper('magebid')->__('Price'),
            'align'         => 'left',
            'index'         => 'price_now',
            'type'          => 'currency',
			'currency_code' => $store->getBaseCurrency()->getCode(),
			'renderer'  =>'adminhtml/report_grid_column_renderer_currency',
        ));				
		
		/*
        $this->addColumn('start_date', array(
            'header'        => Mage::helper('magebid')->__('eBay Start Time'),
            'align'         => 'left',
            'filter_index'  => 'start_date',
            'index'         => 'start_date',
            'type'          => 'datetime',
        ));*/
		
        $this->addColumn('end_date', array(
            'header'        => Mage::helper('magebid')->__('eBay End Time'),
            'align'         => 'left',
            'filter_index'  => 'end_date',
            'index'         => 'end_date',
            'type'          => 'datetime',
        ));

        $this->addColumn('date_created', array(
            'header'        => Mage::helper('magebid')->__('Created'),
            'align'         => 'left',
            'filter_index'  => 'date_created',
            'index'         => 'date_created',
            'type'          => 'datetime'
        ));

        $this->addColumn('page_actions', array(
            'header'    => Mage::helper('magebid')->__('Action'),
            'width'         => '150px',
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => 'magebid/adminhtml_auction_main_grid_renderer_action',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $row->getMagebidAuctionId(),
        ));
    }
	
	
    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }	
	
	protected function _getFormatedLinks()
	{		
		$ebay_link = '<a href="$link"> '.Mage::helper('magebid')->__('eBay Link').'</a><br />';
		$ebay_link .= '<a href="$link"> '.Mage::helper('magebid')->__('Preview').'</a>';
		return $ebay_link;
	}
}
?>
