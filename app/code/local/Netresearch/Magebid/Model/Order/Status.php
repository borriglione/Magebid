<?php
class Netresearch_Magebid_Model_Order_Status extends Mage_Core_Model_Abstract
{		
	protected $_transaction;
	protected $_order;
	protected $_order_id;
	protected $_new_status;
	protected $_tasks = array();
	protected $_comments_mode = false;
	
	protected function _construct()
    {
        $this->_init('magebid/order_status');
    }	
	
	protected function _varSet($order,$new_status)
	{
		//Set Order
		if (!$this->_order)
		{
			$this->_order = $order;
		}
		
		//Set Order ID
		if (!$this->_order_id)
		{
			$this->_order_id = $order->getIncrementId();
		}		
			
		//Get Transaction
		if (!$this->_transaction)
		{
			$this->_transaction = Mage::getModel('magebid/transaction')->load($this->_order_id,'order_id');
		}		
		
		//Set new Status
		if (!$this->new_status)
		{
			$this->new_status = $new_status;
		}
		
		//Check Comments Mode
		if (Mage::getSingleton('magebid/setting')->checkMakeOrderStatusComments()==1)
		{
			$this->_comments_mode = true;
		}		
	}
	
	public function setEbayStatus($order,$new_status)
	{
		//Init
		$this->_varSet($order,$new_status);		
		
		try
		{
			//Try Payment Received
			$this->_setPaymentReceived();
			
			//Try Shipped
			$this->_setShipped();		
			
			//Try Reviewed
			if (Mage::getSingleton('magebid/setting')->checkMakeAutomaticReview()==1) $this->_setReviewed();
			
			//Set Request
			if (!empty($this->_tasks)) Mage::getSingleton('magebid/ebay_sale')->setCompleteSale($this->_transaction,$this->_tasks);			
		}
		catch (Exception $e)
		{
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}		
	}
	
	protected function _setPaymentReceived()
	{
		if ($this->_transaction->getPaymentReceived()==0)
		{
			//Check if the new order state is allowed to change this
			$magento_order_statuses = Mage::getSingleton('magebid/setting')->getOrderStatusPaymentReceived();
			
			if (in_array($this->new_status,$magento_order_statuses)) 
			{
				//Set tasks
				$this->_tasks['paid'] = true;
				
				//Set order to paid
				$data = array('payment_received'=>1);		
				$this->_transaction->addData($data)->save();
				
				//Set success message
				$success_message = Mage::helper('magebid')->__('eBay order %s successful marked as: %s',$this->_order_id,Mage::helper('magebid')->__('Payment received'));
	       		Mage::getSingleton('adminhtml/session')->addSuccess($success_message);					
			
				//Add Comment
				if ($this->_comments_mode)
				{
					$this->_order->addStatusToHistory($this->new_status, $success_message, false);	
					$this->_order->save();						
				}		
			}			
		}		
	}
	
	protected function _setShipped()
	{
		if ($this->_transaction->getShipped()==0)
		{
			//Check if the new order state is allowed to change this
			$magento_order_statuses = Mage::getSingleton('magebid/setting')->getOrderStatusShipped();
			
			if (in_array($this->new_status,$magento_order_statuses)) 
			{
				//Set tasks
				$this->_tasks['shipped'] = true;
				
				//Set order to shipped
				$data = array('shipped'=>1);		
				$this->_transaction->addData($data)->save();
				
				//Set success message
				$success_message = Mage::helper('magebid')->__('eBay order %s successful marked as: %s',$this->_order_id,Mage::helper('magebid')->__('Shipped'));
	       		Mage::getSingleton('adminhtml/session')->addSuccess($success_message);					
				
				//Add Comment
				if ($this->_comments_mode)
				{
					$this->_order->addStatusToHistory($this->new_status, $success_message, false);	
					$this->_order->save();						
				}				
			}	
		}			
	}
	
	protected function _setReviewed()
	{
		if ($this->_transaction->getReviewed()==0)
		{
			//Check if the new order state is allowed to change this
			$magento_order_statuses = Mage::getSingleton('magebid/setting')->getOrderStatusReviewed();
			
			if (in_array($this->new_status,$magento_order_statuses)) 
			{
				//Set tasks
				$this->_tasks['feedback']['text'] = Mage::getSingleton('magebid/setting')->getReviewText();
				$this->_tasks['feedback']['user'] = $this->_transaction->getBuyerEbayUserId();
				
				//Set order to shipped
				$data = array('reviewed'=>1);		
				$this->_transaction->addData($data)->save();
				
				//Set success message
				$success_message = Mage::helper('magebid')->__('eBay order %s successful marked as: %s',$this->_order_id,Mage::helper('magebid')->__('Reviewed'));
	       		Mage::getSingleton('adminhtml/session')->addSuccess($success_message);		       		
			
				//Add Comment
				if ($this->_comments_mode)
				{
					$this->_order->addStatusToHistory($this->new_status, $success_message, false);	
					$this->_order->save();						
				}				
			}	
		}			
	}
	
	
}
?>