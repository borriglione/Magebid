<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Auction_Main_Grid
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Auction_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();
        $this->setId('magebidAuctionList');
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
		$collection = Mage::getModel('magebid/auction')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
	
    /**
     * Prepare Massaction
     *
     * @return object
     */	
    protected function _prepareMassaction()
    {
        
		$this->setMassactionIdField('auction_id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('magebid')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('magebid')->__('Are you sure?')
        ));	
		
        $this->getMassactionBlock()->addItem('export', array(
             'label'    => Mage::helper('magebid')->__('Export to Ebay'),
             'url'      => $this->getUrl('*/*/massExport')
        ));		
		
        $this->getMassactionBlock()->addItem('end', array(
             'label'    => Mage::helper('magebid')->__('End Items'),
             'url'      => $this->getUrl('*/*/massEndItems'),
			 'confirm'  => Mage::helper('magebid')->__('Are you sure?')
        ));				
        return $this;
    }	

    /**
     * Prepare Columns
     *
     * @return object
     */	
    protected function _prepareColumns()
    {
    	$store = Mage::app()->getStore(); 

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
		
        $this->addColumn('magebid_ebay_status_id', array(
            'header'        => Mage::helper('magebid')->__('Status'),
            'index'         => 'magebid_ebay_status_id',
			'type'			=> 'text',
			'type'     		=> 'options',
			'options'   	=> Mage::getSingleton('magebid/auction')->getEbayStatusOptions(),
        	'width'         => '140px',
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
    
    

    /**
     * Return Row-Edit-Url
     *
     * @return string
     */	
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $row->getMagebidAuctionId(),
        ));
    }
    	
    /**
     * Create column for Preview- and Auction-Link
     *
     * @return string
     */	
	protected function _getFormatedLinks()
	{		
		$ebay_link = '<a href="$link"> '.Mage::helper('magebid')->__('eBay Link').'</a><br />';
		$ebay_link .= '<a href="$link"> '.Mage::helper('magebid')->__('Preview').'</a>';
		return $ebay_link;
	}
}
?>
