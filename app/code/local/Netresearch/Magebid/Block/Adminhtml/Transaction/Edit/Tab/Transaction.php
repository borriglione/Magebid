<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Transaction
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Transaction_Edit_Tab_Transaction extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */		
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('transaction_');		
		$store = Mage::app()->getStore();
		
		$disabled = true;

        $auction = $form->addFieldset('auction_form', array('legend'=>Mage::helper('magebid')->__('Transaction')));
	   

        $auction->addField('ebay_item_id', 'text', array(
            'label' => Mage::helper('magebid')->__('Ebay Item Id'),
			'disabled'	=> $disabled,
        ));	   

        $auction->addField('ebay_transaction_id', 'text', array(
            'label' => Mage::helper('magebid')->__('Ebay Transaction Id'),
			'disabled'	=> $disabled,
        ));	  
		
        $auction->addField('checkout_status', 'text', array(
            'label' => Mage::helper('magebid')->__('Checkout Status'),
			'disabled'	=> $disabled,
        ));	  
		
        $auction->addField('complete_status', 'text', array(
            'label' => Mage::helper('magebid')->__('Complete Status'),
			'disabled'	=> $disabled,
        ));	  			
	    
        $auction->addField('total_amount', 'text', array(
            'label' => Mage::helper('magebid')->__('Total'),
			'disabled'	=> $disabled,
        ));

        $auction->addField('single_price', 'text', array(
            'label' => Mage::helper('magebid')->__('Single Price'),
			'disabled'	=> $disabled,
        ));		
		
        $auction->addField('quantity', 'text', array(
            'label' => Mage::helper('magebid')->__('Quantity Sold'),
			'disabled'	=> $disabled,
        ));	   

		$outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $auction->addField('date_created', 'date',array(
                'name'      =>    'date_created',
                'time'      =>    true,
				'style'		=> 'width:98%;',
                'format'    =>    $outputFormat,
           		'label'     => 	  Mage::helper('magebid')->__('Created at'),
				'disabled'	=> $disabled,
            ));	
			
        $auction->addField('last_updated', 'date',array(
                'name'      =>    'last_updated',
                'time'      =>    true,
				'style'		=>    'width:98%;',
                'format'    =>    $outputFormat,
           		'label'     => 	  Mage::helper('magebid')->__('Last updated'),
				'disabled'	=> $disabled,
            ));				
		
		
        $auction->addField('product_id', 'text', array(
            'label' => Mage::helper('magebid')->__('Product Id'),
			'disabled'	=> $disabled,
        ));       
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $transaction = Mage::registry('frozen_magebid')->getData();
		if ($transaction['date_created']!="") $form->getElement('date_created')->setValue(
                Mage::app()->getLocale()->date($transaction['date_created'], Varien_Date::DATETIME_INTERNAL_FORMAT)
            );  	
			
        $transaction = Mage::registry('frozen_magebid')->getData();
		if ($transaction['last_updated']!="") $form->getElement('last_updated')->setValue(
                Mage::app()->getLocale()->date($transaction['last_updated'], Varien_Date::DATETIME_INTERNAL_FORMAT)
            );  	
					
        $this->setForm($form);
        return parent::_prepareForm();	
	}
}
?>
