<?php
/**
 * Mbid_Magebid_Model_Transaction
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Transaction extends Mage_Core_Model_Abstract
{	
    /**
     *  Auction-Data
     * @var array
     */	
	protected $_auction_data = array();
	
    /**
     * Status String of an completed Order in eBay
     */	
	const EBAY_ORDER_STATUS_COMPLETED = "Completed";	
	
    /**
     * Construct
     *
     * @return void
     */	
	protected function _construct()
    {
        $this->_init('magebid/transaction');
    }
    
    /**
     * Get Transaction Collection
     * @return object
     */
	public function getCollection()
	{
		$collection = parent::getCollection();	
		$collection->joinFields();	
		return $collection;
	}		
	
    /**
     * Prepare Transaction Data to save it in the database
     * The Information comes from the eBay Call
     * 
     * @param object $raw_transaction Raw transaction information (eBay Call) from ebay
     * 
     * @return array
     */	
	protected function _prepareTransactionData($raw_transaction)
	{
		$transaction_array = array();		
		
		//in case of new transaction which is not already existing in the database		
		if (isset($this->_auction_data['ebay_item_id'])) $transaction_array['ebay_item_id'] = $this->_auction_data['ebay_item_id'];
		if (isset($this->_auction_data['auction_name'])) $transaction_array['auction_title'] =  $this->_auction_data['auction_name'];
		if (isset($this->_auction_data['product_id'])) $transaction_array['product_id'] = $this->_auction_data['product_id'];
		if (isset($this->_auction_data['product_sku'])) $transaction_array['product_sku'] = $this->_auction_data['product_sku'];		
		
		//If a transaction_id is existing | otherweise it is an auction or single qty item		
		if ($raw_transaction->TransactionID!="") $transaction_array['ebay_transaction_id'] = $raw_transaction->TransactionID;
		
		//Basis Transaction Data
		$transaction_array['buyer_ebay_user_id'] = $raw_transaction->Buyer->UserID;
		$transaction_array['last_updated'] = Mage::getSingleton('core/date')->gmtDate();
		$transaction_array['date_created'] = $raw_transaction->CreatedDate;
		$transaction_array['checkout_status'] = $raw_transaction->Status->CheckoutStatus;	
		$transaction_array['complete_status'] = $raw_transaction->Status->CompleteStatus;
		
		//Set Payment Method		
		$transaction_array['payment_method'] = $raw_transaction->Status->PaymentMethodUsed;
		$transaction_array['payment_hold_status'] = $raw_transaction->Status->PaymentHoldStatus;
		$transaction_array['payment_status'] = $raw_transaction->Status->eBayPaymentStatus;
		
		//Set Shipping Method
		$transaction_array['shipping_method'] = $raw_transaction->ShippingServiceSelected->ShippingService;
		$transaction_array['shipping_cost'] = $raw_transaction->ShippingServiceSelected->ShippingServiceCost->value;
		$transaction_array['shipping_add_cost'] = $raw_transaction->ShippingServiceSelected->ShippingServiceAdditionalCost->value;
		
		//Price Info
		$transaction_array['single_price'] = $raw_transaction->ConvertedTransactionPrice->value;		
		$transaction_array['quantity'] = $raw_transaction->QuantityPurchased;
		$total_price = $transaction_array['single_price']*$transaction_array['quantity'] + $transaction_array['shipping_cost'];		
		$transaction_array['total_amount'] = $total_price;		
		//$transaction_array['tax'] = $raw_transaction->ConvertedTransactionPrice->value;		
		
		//eBay Order Info
		$transaction_array['ebay_order_id'] = $raw_transaction->ContainingOrder->OrderID;
		$transaction_array['ebay_order_status'] = $raw_transaction->ContainingOrder->OrderStatus;

		//Return Encoded Array
		return $transaction_array;
	}
	
    /**
     * Prepare Transaction User Data to save it in the database
     * The Information comes from the eBay Call
     * 
     * @param object $raw_transaction Raw transaction information (eBay Call) from ebay
     * 
     * @return array
     */		
	protected function _prepareTransactionUserData($raw_transaction)
	{
		$transaction_user_array = array();		
		
		//Get the transaction-id
		$transaction_user_array['magebid_transaction_id'] = $this->getId();		
		
		//Set eMail-Adress of the buyer
		$transaction_user_array['buyer_email'] = $raw_transaction->Buyer->Email;
		
		//Set Billing/Registration Information
		$transaction_user_array['registration_name'] = $raw_transaction->Buyer->RegistrationAddress->Name;
		$transaction_user_array['registration_street'] = $raw_transaction->Buyer->RegistrationAddress->Street;
		$transaction_user_array['registration_street_add'] = $raw_transaction->Buyer->RegistrationAddress->Street1;
		$transaction_user_array['registration_city'] = $raw_transaction->Buyer->RegistrationAddress->CityName;
		$transaction_user_array['registration_zip_code'] = $raw_transaction->Buyer->RegistrationAddress->PostalCode;
		$transaction_user_array['registration_country'] = $raw_transaction->Buyer->RegistrationAddress->Country;
				
		//Set Shipping Information
		$transaction_user_array['shipping_name'] = $raw_transaction->Buyer->BuyerInfo->ShippingAddress->Name;
		$transaction_user_array['shipping_street'] = $raw_transaction->Buyer->BuyerInfo->ShippingAddress->Street1;
		$transaction_user_array['shipping_city'] = $raw_transaction->Buyer->BuyerInfo->ShippingAddress->CityName;
		$transaction_user_array['shipping_zip_code'] = $raw_transaction->Buyer->BuyerInfo->ShippingAddress->PostalCode;
		$transaction_user_array['shipping_country'] = $raw_transaction->Buyer->BuyerInfo->ShippingAddress->Country;

		//Return Encoded Array
		return $transaction_user_array;
	}		
	
    /**
     * Main Method for save (create or update) an eBay Transaction
     * 
     * If the transaction is not already existing and complete, create one
     * If the transaction is incomplete, update it
     * 
     * @param object $raw_transaction Raw transaction information (eBay Call) from ebay
     * 
     * @return boolean
     */			
	public function saveOrUpdate($raw_transaction)
	{
		$new_transaction = $this->getId() ? false : true;
	
		//get ebay_item_id
		$ebay_item_id = $raw_transaction->Item->ItemID;

		//get (if existing) transaction_id
		//if there is no transaction_id existing, it is a single quantity item or an bid-auction
		if ($raw_transaction->TransactionID!="") $ebay_transaction_id = $raw_transaction->TransactionID;
		
		//Try to load the transaction by transaction_id or item_id
		if (isset($ebay_transaction_id)) $this->load($ebay_transaction_id,'ebay_transaction_id');
		else $this->load($ebay_item_id,'ebay_item_id');

		//Load auction
		$auction = Mage::getModel('magebid/auction')->load($ebay_item_id,'ebay_item_id');
		
		//Return false for the following conditions 
		if ($this->getCompleteStatus()=='Complete') return false; //If the order-information is already complete
		if ($this->getOrderCreated()==1) return false; //If an order was created already for a transaction
		if (!$auction->getId()) return false; //If aution data is not existing for this transaction
		
		//Assign Information of the ebay auction
		$this->_auction_data = $auction->getData();

		//prepare transaction data and save it
		$data = $this->_prepareTransactionData($raw_transaction);
		$this->addData($data)->save();		
		
		//prepare transaction user data and save it
		$data = $this->_prepareTransactionUserData($raw_transaction);
		Mage::getModel('magebid/transaction_user')->load($this->getMagebidTransactionUserId())->addData($data)->save();			
				
		
		 //If it is an existing Transaction->Update
		if (!$new_transaction && Mage::getStoreConfig('magebid/magebid_notices/transaction_notice'))
		{
	        Mage::getSingleton('adminhtml/session')->addSuccess(
	                    Mage::helper('magebid')->__('A transaction (%s) for auction %s was successfully updated',$this->getEbayTransactionId(),$this->getEbayItemId()));		
		}
		else if ($new_transaction && Mage::getStoreConfig('magebid/magebid_notices/transaction_notice')) //if it is a new transaction
		{
	        Mage::getSingleton('adminhtml/session')->addSuccess(
	                    Mage::helper('magebid')->__('A transaction (%s) for auction %s was successfully generated',$this->getEbayTransactionId(),$this->getEbayItemId()));		
		}		
		
		//Try to create a Magento Order
		$this->_tryCreateOrder();	

		return true;
	}
	
    /**
     * Method to check if there is a new single item order to create
     * 
     * If the transaction is complete, the order not already created and consists only of one item->create it
     * Save the Magento Order ID to the transaction and set a success-message
     * 
     * @return boolean
     */		
	protected function _tryCreateOrder()
	{		
		//if checkout_status is complete, not already created and if it is a single-item order		
		if ($this->getCompleteStatus()=='Complete' && $this->getOrderCreated()==0 && $this->getEbayOrderId()=='')
		{
			if ($order = Mage::getModel('magebid/order_create')->createImportOrder($this->load($this->getId())))
			{
				//Get order_id
				$order_id = $order->getIncrementId();				
				
				//Set "order created" on transaction
				$data = array('order_created'=>1,'order_id'=>$order_id);		
				$this->addData($data)->save();         
				
				//Add success message
				Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('magebid')->__('Order (%s) for Auction %s / Transaction %s was created successfully',$order_id,$this->getEbayItemId(),$this->getEbayTransactionId())
                );	
				
				//Check if order state should be changed
				Mage::getModel('magebid/order_status')->setEbayStatus($order,$order->getStatus(),'',true); 

				return true;
			}
			else return false;
		}			
	}

    /**
     * Method to check if there is a new multiple item order to create
     * 
     * If the ebay order is complete and not already created
     * Save the Magento Order ID to the transaction and set a success-message
     * 
     * @return boolean
     */		
	public function tryCreateMultipleItemOrders()
	{	
		//Get different eBay Orders which are not transformed into magento orders
		$orders = $this->getResource()->getDifferentOrders();
		
		//For every order which is completed in ebay but not already created in Magento
		foreach ($orders as $order)
		{
			//get every transaction for an ebay_order_id 
			$transactions = $this->getCollection();
			$transactions->addFieldToFilter('ebay_order_id', $order['ebay_order_id']);		
			$transactions->load();
			
			//If a Magento Order can be created
			if ($order = Mage::getModel('magebid/order_create')->createImportOrder($transactions->getItems()))
			{
				//Get new order_id
				$order_id = $order->getIncrementId();				
				
				//Set "order created" on transaction
				$data = array('order_created'=>1,'order_id'=>$order_id);	

				//Save this status for every transaction
				foreach ($transactions as $transaction)
				{
					$transaction->addData($data)->save();   

					//Add success message
					Mage::getSingleton('adminhtml/session')->addSuccess(
	                    Mage::helper('magebid')->__('Order (%s) for Auction %s / Transaction %s was created successfully',$order_id,$transaction->getEbayItemId(),$transaction->getEbayTransactionId())
	                );						
				}				
				
				//Check if order state should be changed
				Mage::getModel('magebid/order_status')->setEbayStatus($order,$order->getStatus(),'',true); 	

				return true;
			}	
			else return false;
		}
	}
	
	
    /**
     * Update transactions of multiple-item-orders with the eBay GetOrderTransactions-Call
     * 
     * @return void
     */	
	public function updateEbayOrders()
	{
		//Get different eBay Orders which are not transformed into magento orders
		$orders = $this->getResource()->getDifferentOrders();
		
		//For every order which is completed in ebay but not already created in Magento
		$order_ids = array();
		foreach ($orders as $order)
		{		
			$order_ids[] = $order['ebay_order_id'];
		}
		
		//Make the GetOrderTransactions-Call
		if (count($order_ids)>0)
		{
			$results = Mage::getModel('magebid/ebay_transaction')->getOrderTransactions($order_ids);
		}		
		
		//For every order-result
		if (count($results)>0)
		{
			foreach ($results as $result)
			{
				//get every transaction for an ebay_order_id 
				$transactions = $this->getCollection();
				$transactions->addFieldToFilter('ebay_order_id', $result['ebay_order_id']);		
				$transactions->load();
				
				//Save the order-result informations for every transaction
				foreach ($transactions as $transaction)
				{
					$transaction->addData($result)->save();  					
				}	
			}	
		}	
	}
	
    /**
     * Mark transactions as payment_received
     * 
     * @param int $magento_order_id Magento Order Id
     * 
     * @return void
     */	
	public function setTransactionsAsPaymentReceived($magento_order_id)
	{
		foreach ($this->_getTransactionsByMagentoOrderId($magento_order_id) as $transaction)
		{
			//Set order to paid
			$data = array('payment_received'=>1);		
			$transaction->addData($data)->save();
		}
	}
	
    /**
     * Mark transactions as shipped
     * 
     * @param int $magento_order_id Magento Order Id
     * 
     * @return void
     */	
	public function setTransactionsAsShipped($magento_order_id)
	{
		foreach ($this->_getTransactionsByMagentoOrderId($magento_order_id) as $transaction)
		{
			//Set order to paid
			$data = array('shipped'=>1);		
			$transaction->addData($data)->save();
		}
	}

    /**
     * Mark transactions as reviewed
     * 
     * @param int $magento_order_id Magento Order Id
     * 
     * @return void
     */	
	public function setTransactionsAsReviewed($magento_order_id)
	{
		foreach ($this->_getTransactionsByMagentoOrderId($magento_order_id) as $transaction)
		{
			//Set order to paid
			$data = array('reviewed'=>1);		
			$transaction->addData($data)->save();
		}
	}
	
	
    /**
     * Get all transactions for a Magento Order Id
     * 
     * @param int $magento_order_id Magento Order Id
     * 
     * @return object
     */	
	protected function _getTransactionsByMagentoOrderId($magento_order_id)
	{
			//get every transaction for an ebay_order_id 
			$transactions = $this->getCollection();
			$transactions->addFieldToFilter('order_id', $magento_order_id);		
			$transactions->load();
			return $transactions;
	}
}
?>
