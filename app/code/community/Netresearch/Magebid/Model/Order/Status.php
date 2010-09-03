<?php
/**
 * Netresearch_Magebid_Model_Order_Status
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Model_Order_Status extends Mage_Core_Model_Abstract
{		
    /**
     * Magebid Transaction
     * @var object
     */		
	protected $_transaction;
	
    /**
     * Magento Order
     * @var object
     */			
	protected $_order;
	
    /**
     * Magento Order Id
     * @var int
     */			
	protected $_order_id;
	
    /**
     * new Magento Order Status
     * @var string
     */			
	protected $_new_status;
	
    /**
     * Tasks for the eBay Feedback Call
     * @var array
     */			
	protected $_tasks = array();
	
    /**
     * If comments to Magento Orders should made, when status changes in eBay was processed
     * @var boolean
     */			
	protected $_comments_mode = false;
	
    /**
     * Comments for the Magento Order Status 
     * @var string
     */			
	protected $_comments = "";
	
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/order_status');
    }		
    
    /**
     * Initial Function
     * 
     * @param object $order Magento Order
     * @param string $new_status New Order Status
     *
     * @return void
     */	    
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
			$this->_order_id = $this->_order->getIncrementId();
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
	
    /**
     * Main Function to change the ebay order status
     * 
     * @param object $order Magento Order
     * @param string $new_status New Order Status
     * @param string $order_comment Magento Order comment
     * @param boolean $new_order If it is a new Magento Order
     *
     * @return void
     */	  	
	public function setEbayStatus($order,$new_status,$order_comment = '',$new_order = false)
	{		
		//Init
		$this->_varSet($order,$new_status);		
		
		try
		{
			//Build Order comment
			if ($order_comment!='') $this->_addComment($order_comment);					
		
			//Try Payment Received
			$this->_setPaymentReceived();
			
			//Check special cases (f.e. COD-Payments)
			$this->_giveSpecialFeedback();
			
			//Try Shipped
			$this->_setShipped();		
			
			//Try Reviewed
			$this->_setReviewed();
			
			//Set Request
			if (!empty($this->_tasks))
			{
				Mage::getSingleton('magebid/ebay_sale')->setCompleteSale($this->_transaction,$this->_tasks);			

				//If it is a new order we have to set the order-comment manually
				if ($new_order)
				{
					$this->_order->addStatusToHistory($this->new_status, $this->_comments, false);	
					$this->_order->save();		
				}
			}
			
			return $this->_comments;
		}
		catch (Exception $e)
		{
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}		
	}
	
	
    /**
     * set eBay Order Status as "payment received"
     * 
     * @return void
     */	
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
				Mage::getModel('magebid/transaction')->setTransactionsAsPaymentReceived($this->_order_id);
				
				//Set success message
				$success_message = Mage::helper('magebid')->__('eBay order %s successful marked as: %s',$this->_order_id,Mage::helper('magebid')->__('Payment received'));
	       		Mage::getSingleton('adminhtml/session')->addSuccess($success_message);					
			
				//Add Comment
				if ($this->_comments_mode)
				{
					$this->_addComment($success_message);				
				}		
			}			
		}		
	}
	
    /**
     * set eBay Order Status as "shipped"
     * 
     * @return void
     */		
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
				Mage::getModel('magebid/transaction')->setTransactionsAsShipped($this->_order_id);
				
				//Set success message
				$success_message = Mage::helper('magebid')->__('eBay order %s successful marked as: %s',$this->_order_id,Mage::helper('magebid')->__('Shipped'));
	       		Mage::getSingleton('adminhtml/session')->addSuccess($success_message);					
				
				//Add Comment
				if ($this->_comments_mode)
				{
					$this->_addComment($success_message);				
				}				
			}	
		}			
	}
	
    /**
     * leave Feedback for eBay User
     * 
     * @return void
     */		
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
				
				//Set order to reviewed
				Mage::getModel('magebid/transaction')->setTransactionsAsReviewed($this->_order_id);
				
				//Set success message
				$success_message = Mage::helper('magebid')->__('eBay order %s successful marked as: %s',$this->_order_id,Mage::helper('magebid')->__('Reviewed'));
	       		Mage::getSingleton('adminhtml/session')->addSuccess($success_message);		       		
			
				//Add Comment
				if ($this->_comments_mode)
				{
					$this->_addComment($success_message);				
				}				
			}	
		}			
	}
	
	
    /**
     * Method to give a feedback "payment received" to eBay in special conditions
     * 
     * This method is used only for special payment methods, see Jira NRMB-80
     * The problem is, that eBay "COD"-Payments give the ebay order status "complete" but
     * the order isn't real complete. There is still the possibility to do the checkout for the 
     * same items again, and a new ebay-order-it will be created. To avoid this, Magebid has to
     * give a "payment received" feedback to ebay
     * 
     * @return void
     */		
	protected function _giveSpecialFeedback()
	{	
		//If transaction is not already marked as payment received
		//if payment method is COD
		if ($this->_transaction->getPaymentReceived()==0  && $this->_transaction->getPaymentMethod()=="COD")
		{
			if ($this->_tasks['paid']!=true)
			{
				//Set tasks
				$this->_tasks['paid'] = true;
				
				//Set order to paid
				Mage::getModel('magebid/transaction')->setTransactionsAsPaymentReceived($this->_order_id);
				
				//Set success message
				$success_message = Mage::helper('magebid')->__('eBay order %s successful marked as: %s',$this->_order_id,Mage::helper('magebid')->__('Payment received'));
	       		Mage::getSingleton('adminhtml/session')->addSuccess($success_message);					
			
				//Add Comment
				if ($this->_comments_mode)
				{
					$this->_addComment($success_message);				
				}						
			}		
		}		
	}
	
	protected function _addComment($comment)
	{
     	if ($this->_comments=='')
     	{
     		$this->_comments=$comment; 
     	}
     	else
     	{
     		$this->_comments.=" | ".$comment;
     	}     	
	}
}
?>