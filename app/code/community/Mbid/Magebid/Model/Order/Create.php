<?php
/**
 * Mbid_Magebid_Model_Order_Create
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_Order_Create extends Mage_Adminhtml_Model_Sales_Order_Create
{
    /**
     * All eBay Transactions for this order
     * @var array
     */	
	protected $_transactions = array();
	
    /**
     * Magebid Transaction
     * @var object Mbid_Magebid_Model_Transaction
     */		
	protected $_reference_transaction;
	
    /**
     * Import Store
     * @var object 
     */			
	protected $_store;
	
    /**
     * Customer in Magento
     * @var object 
     */			
	protected $_customer;
	
    /**
     * Customer ID in Magento
     * @var int 
     */			
	protected $_customer_id;
	
    /**
     * Checkout Quote
     * @var object 
     */		
	protected $_quote;

	/**
     * Checkout Quote Convert
     * @var object 
     */		
	protected $_quote_convert;
	
	/**
     * Magento Order
     * @var object 
     */		
	protected $_order;
	
	/**
     * Magento Order Items (Products)
     * @var array 
     */			
	protected $_order_item;	
	
    /**
     * Construct
     *
     * @return void
     */		
	protected function _construct()
    {
        $this->_init('magebid/order_create');
    }	
    
    /**
     * Main Order Create Function
     * 
     * @param array $transactions Transactions to create the order
     *
     * @return object|boolean
     */	      
	public function createImportOrder($transactions)
	{
		//Get Transaction
		if (!is_array($transactions)) //single transaction
		{
			$this->_transactions[] = $transactions;
			$this->_reference_transaction = $transactions;
		}
		else //multiple transactions
		{
			$this->_transactions = $transactions;
			$this->_reference_transaction = array_shift($transactions);
		}		
		
		//Get Default Store Id for Magebid Order Import
		$default_store_id = Mage::getStoreConfig('magebid/magebid_order_import/import_default_store');
		$this->_store = Mage::getModel('core/store')->load($default_store_id);
		
		//Create Customer
		$this->_createCustomer();		
		
		//Set billing Address
		$this->_setBillingAddress();
		
		//Set billing Address
		$this->_setShippingAddress();		
		
		//Save address settings
		$this->_customer->save();		
		
		//Create Quotes
		$this->_createQuote();
		
		//Add products to quote
		$this->_setQuoteProducts();
		
		//Save quote
		try
		{
			$this->_quote->reserveOrderId();
			$this->_quote->save();				
		}
		catch (Exception $e)
		{
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magebid')->__('Error saving quote').'<br />'.$e->getMessage());
        }
	
		//Set Order Shipping Method
		$this->_setOrderShippingMethod();
		
		//Set Order Payment Method
		$this->_setOrderPaymentMethod();		
		
		//Get Totals
		$this->_quote->collectTotals();
		$this->_quote->getTotals();		
		
		//Save quote
		try
		{
			$this->_quote->save();			
		}
		catch (Exception $e)
		{
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magebid')->__('Error saving quote').'<br />'.$e->getMessage());
        }		
		
		//Create order
		$this->_createOrder();	
		
		//Set order products
		$this->_setOrderProducts();					
		
		//Set OrderNote
		$this->_setOrderNote();	

		//Final try to save order
		try
		{
			$this->_order->place();
			$this->_order->save();
			$this->_quote->setIsActive(false);
	        $this->_quote->save();

	        //Log
	        foreach ($this->_transactions as $transaction)
			{
				Mage::getModel('magebid/log')->logSuccess("order-create","transaction ".$transaction->getEbayTransactionId()." / order ".$this->_order->getIncrementId(),"","","");
			}	        
	        
			return $this->_order;		
		}
		catch (Exception $e)
		{
                //Log
		        foreach ($this->_transactions as $transaction)
				{
					 Mage::getModel('magebid/log')->logError("order-create","transaction ".$transaction->getEbayTransactionId(),"","",$e->getMessage());
				}	

				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('magebid')->__('Error creating order').'<br />'.$e->getMessage());
        		return false;
		}			
	}
	
    /**
     * Create/Update a Magento Customer for the new Order
     * 
     * @return void
     */	      	
	protected function _createCustomer()
	{
		//Check if customer with this mail_adress is allready existing
		$customers = Mage::getModel('customer/customer')->getCollection()->addAttributeToSelect('*')->addFieldToFilter('email', $this->_reference_transaction->getBuyerEmail());
		$customer = $customers->load()->getItems();
		$customer = current($customer);
		$customer_id = null;
		
		//If customer with this mail adress is allready existing
		if ($customer instanceof Mage_Customer_Model_Customer)
		{
			$customer_id = $customer->getId();				
		}
		else
		{
			 $customer = Mage::getModel('customer/customer');
			 $customer->generatePassword();	
		}		
		
		//Create/Update Customer Data if it is choosed in the backend settings
		if (Mage::getStoreConfig('magebid/magebid_order_import/update_customer_data'))
		{
			$customer_data = $this->_getCustomerData();	
		    $customer->addData($customer_data)->setId($customer_id);		
		    $customer->save();			
		}
		
		//Get customer_id
	    $this->_customer_id = $customer->getId();
		$this->_customer = $customer;
	}
	
    /**
     * Return Data to create a new customer
     * 
     * @return array
     */	 	
	protected function _getCustomerData()
	{
		return array(   		
	    				'email' 	=>		$this->_reference_transaction->getBuyerEmail(),
	    				'lastname'	=> 		Mage::helper('magebid_order')->getSplitedLastname($this->_reference_transaction->getRegistrationName()),
	    				'firstname'	=> 		Mage::helper('magebid_order')->getSplitedFirstname($this->_reference_transaction->getRegistrationName()),
						'store_id'	=> 		$this->_store->getId(),
						'website_id'=> 		$this->_store->getWebsiteId(),
	    				'created_at'=>		$this->_reference_transaction->getDateCreated(),
	    				'updated_at'=>		$this->_reference_transaction->getDateCreated(),
	    );			
	}
	
    /**
     * Return Data to create a shipping address
     * 
     * @return array
     */		
	protected function _getCustomerShippingAddressData()
	{
		return array(   		
		    				'lastname'	=> 		Mage::helper('magebid_order')->getSplitedLastname($this->_reference_transaction->getShippingName()),
		    				'firstname'	=> 		Mage::helper('magebid_order')->getSplitedFirstname($this->_reference_transaction->getShippingName()),
				    		'street'	=>		$this->_reference_transaction->getShippingStreet(),
				    		'postcode'	=>		$this->_reference_transaction->getShippingZipCode(),
				    		'city'		=>		$this->_reference_transaction->getShippingCity(),
				    		'country_id'=>		$this->_reference_transaction->getShippingCountry(),
				    		//'telephone'	=>		'',
				    		//'fax'		=>		''
	    );			
	}

    /**
     * Return Data to create a billing address
     * 
     * @return array
     */	
	protected function _getCustomerBillingAddressData()
	{
		return array(   		
		    				'lastname'	=> 		Mage::helper('magebid_order')->getSplitedLastname($this->_reference_transaction->getRegistrationName()),
		    				'firstname'	=> 		Mage::helper('magebid_order')->getSplitedFirstname($this->_reference_transaction->getRegistrationName()),
				    		'street'	=>		$this->_reference_transaction->getRegistrationStreet(),
				    		'postcode'	=>		$this->_reference_transaction->getRegistrationZipCode(),
				    		'city'		=>		$this->_reference_transaction->getRegistrationCity(),
				    		'country_id'=>		$this->_reference_transaction->getRegistrationCountry(),
				    		//'telephone'	=>		'',
				    		//'fax'		=>		''
	    );			
	}	
	
    /**
     * Return Address object to store it in the database
     * 
     * @return object 
     */		
	protected function _createCustomerAddress($shipping_address_data)
	{
	    				$address = Mage::getModel('customer/address');
	    				$address->setData($shipping_address_data);
	    				$address->setCreatedAt($this->_reference_transaction->getDateCreated());
	    				$address->setUpdatedAt($this->_reference_transaction->getDateCreated());
	    				$address->setCustomerId($this->_customer_id);
	    				$address->setParentId($this->_customer_id);
		    			$address->save();
						return $address;			
	}

    /**
     * Save Billing Address
     * 
     * @return void
     */		
	protected function _setBillingAddress()
	{
		//Set Billing Address
		$billing_address_data = $this->_getCustomerBillingAddressData();
	    $billing_address = Mage::helper('magebid_order')->compareCustomerAddress($this->_customer, $billing_address_data);
	    if (!$billing_address)
		{    			
	    		$billing_address = $this->_createCustomerAddress($billing_address_data);
				$this->_customer->addAddress($billing_address);
	    }	
		$this->_customer->setDefaultBilling($billing_address->getEntityId());			
	}
	
    /**
     * Save Shipping Address
     * 
     * @return void
     */			
	protected function _setShippingAddress()
	{
		//Set Shipping Address
		$shipping_address_data = $this->_getCustomerShippingAddressData();
	    $shipping_address = Mage::helper('magebid_order')->compareCustomerAddress($this->_customer, $shipping_address_data);
	    if (!$shipping_address)
		{    			
	    		$shipping_address = $this->_createCustomerAddress($shipping_address_data);
				$this->_customer->addAddress($shipping_address);
				$this->_customer->setDefaultShipping( $shipping_address->getEntityId() );
	    }
		$this->_customer->setDefaultShipping($shipping_address->getEntityId());		
	}
	
    /**
     * Save Billing Address
     * 
     * @return void
     */			
	protected function _getRawQuoteProducts()
	{
		$items = array();		
		foreach ($this->_transactions as $transaction)
		{	
			$items[$transaction->getProductSku()]['qty'] += $transaction->getQuantity();
			$items[$transaction->getProductSku()]['single_price'] = $transaction->getSinglePrice();
		}		
		return $items;
	}
	
    /**
     * Save quote Items / Products to assign them to the quote
     * 
     * @return void
     */	
	protected function _setQuoteProducts()
	{		
		//Get Raw Quote Products
		$items = $this->_getRawQuoteProducts();
		
		foreach ($items as $sku => $item)
		{		
			//Set product		
			$this->_order_item = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku);
			
			//If order_item is a product
			if ($this->_order_item instanceof Mage_Catalog_Model_Product)
			{			
				$this->_order_item->setStockItem(Mage::getModel('catalog/product')->load($this->_order_item->getProductId())->getStockItem());
				
				//Catalog Prices exclude Tax
				if (!Mage::helper('tax')->priceIncludesTax()) { 
					//Remove Tax from eBay-Prices (Brutto->Netto)
					$product_price = Mage::helper('tax')->getPrice($this->_order_item, $item['single_price'], false, null,null,null,null,true);
					$this->_order_item->setPrice($product_price);
				}
				else { //Catalog Prices include Tax
					$this->_order_item->setPrice($item['single_price']);
				} 	
						
				/*
				 * Disable the special price for the product (fixed BUG with this setting. If the special price
				 * isn't disabled, Magento takes the special price instead the item price we get from eBay
				 */				
				$this->_order_item->setSpecialPrice(false);
				
				
				$this->_order_item->setSku($sku);
			}
			
			//Try to add products
			try	{
			    	$this->_quote_item = $this->_quote->addProduct($this->_order_item, new Varien_Object( array( 'qty' => $item['qty'], 'product' => $this->_order_item->getId())));
			}
			catch (Exception $e) {
			    	$error_message .= Mage::helper('magebid')->__('Auction item %s is out of stock. The requested amount was %d', $this->_order_item->getName() , $item['qty']).'<br />';
			}				
		}			
	}
	
    /**
     * Create the quote
     * 
     * @return void
     */		
	protected function _createQuote()
	{		
		$this->_quote = Mage::getModel('sales/quote')->setStoreId($this->_store->getId());
		$this->_quote->setCustomer($this->_customer);
		$this->_quote->getBillingAddress()->importCustomerAddress($this->_customer->getDefaultBillingAddress());
		$this->_quote->getShippingAddress()->importCustomerAddress($this->_customer->getDefaultShippingAddress());	
	}
	
    /**
     * Create the Order Shipping Method
     * 
     * @return void
     */		
	protected function _setOrderShippingMethod()
	{
		//Check if there is a mapping for the ebay-shipping-methid
		if (!$shipping_method = $this->_checkShippingMethodMapping())
		{
			$shipping = Mage::getModel('magebid/import_shipping')->load($this->_reference_transaction->getShippingMethod(),'shipping_service');
			
			$shipping_method = array(
				'code' => "ebay_shipping",
				'carrier' => "eBay",
				'method' => "shipping",
				'carrier_title' => "ebay",
				'method_title' => $shipping->getDescription(),				
				);				
		}			
		
		//Set Shipping Method		
        $this->_quote->getShippingAddress()->setShippingMethod($shipping_method['code']);  
		
        //Get Total Shipping Price
        $shipping_price = 0;
        foreach ($this->_transactions as $transaction)
		{  			
			$shipping_price = $shipping_price+$transaction->getShippingCost();
		}      
		
		
        //Create Rate    
        $shipping_rate = new Mage_Shipping_Model_Rate_Result_Method();
		$rate = Mage::getModel('sales/quote_address_rate')
                    ->importShippingRate($shipping_rate);
		
		//Set Rate (Prices)			
        $rate
                ->setCode($shipping_method['code'])
                ->setCarrier($shipping_method['carrier'])
                ->setCarrierTitle($shipping_method['carrier_title'])
                ->setMethod($shipping_method['method'])
                ->setMethodTitle($shipping_method['method_title'])
                ->setMethodDescription(" ");
                		

        //Tax check
        //Shipping Prices exclude Tax
        if (!Mage::helper('tax')->shippingPriceIncludesTax()) {
        	//thx Mage_Tax_Helper_Data->getShippingPrice for this "nice" solution
	        $pseudoProduct = new Varien_Object();
	        $pseudoProduct->setTaxClassId(Mage::helper('tax')->getShippingTaxClass($store));  	        
        	$shipping_price = Mage::helper('tax')->getPrice($pseudoProduct, $shipping_price, false, null,null,null,null,true);
        	$rate->setPrice($shipping_price);
        }
        else { //Shipping Prices include Tax
        	$rate->setPrice($shipping_price);
        }
					
		$this->_quote->getShippingAddress()->addShippingRate($rate);		
	}	
	
    /**
     * Create the Order Payment Method
     * 
     * @return void
     */			
	protected function _setOrderPaymentMethod()
	{		
		//Get Mapped Payment Method
		/*
		if (!$payment_method = $this->_getMappedPaymentMethod($this->_transaction->getPaymentMethod()))
		{
			throw new Exception (Mage::helper('magebid')->__('No mapped Payment Method Existing'));
		}	*/	
		
		$this->_quote_payment = Mage::getModel('sales/quote_payment')
						->setMethod("free"); 							//ToFix
		$this->_quote_payment->setQuote($this->_quote);
		$this->_quote->addPayment($this->_quote_payment);	
	}
	
    /**
     * Create the Order
     * 
     * @return void
     */			
	protected function _createOrder()
	{
		$this->_quote_convert = Mage::getModel('sales/convert_quote');
		$this->_order = $this->_quote_convert->addressToOrder($this->_quote->getShippingAddress());
		$this->_order->setBillingAddress($this->_quote_convert->addressToOrderAddress($this->_quote->getBillingAddress()))
			  ->setPayment($this->_quote_convert->paymentToOrderPayment($this->_quote->getPayment()));		
		$this->_order->setShippingAddress($this->_quote_convert->addressToOrderAddress($this->_quote->getShippingAddress()));	
	}
	
    /**
     * Assign the quote items to the order
     * 
     * @return void
     */			
	protected function _setOrderProducts()
	{		
		//Set every product
		foreach ($this->_quote->getAllItems() as $item)
		{
			    $this->_order_item = $this->_quote_convert->itemToOrderItem($item);
			    if ($item->getParentItem()) {
			       $this->_order_item->setParentItem($this->_order->getItemByQuoteItemId($item->getParentItem()->getId()));
			    }

		        if ($item->getParentItem()) {
		            $this->_order_item->setParentItem($this->_order->getItemByQuoteItemId($item->getParentItem()->getId()));
		        }
				
			    $this->_order->addItem($this->_order_item);
		}			
	}
	
    /**
     * Set a Payment Note to the order comments
     * 
     * @return void
     */			
	protected function _setOrderNote()
	{
		$magebid_note = Mage::helper('magebid')->__('Payment Method: %s',$this->_reference_transaction->getPaymentMethod());
		
		$this->_order->setCustomerNote($magebid_note);		
	}
	
    /**
     * Check if a mapping for the shipping method is existing
     * 
     * @return array|boolean If mapping is existing, return array $data, else return false
     */			
	protected function _checkShippingMethodMapping()
	{
		$transaction_shipping_method = $this->_reference_transaction->getShippingMethod();
		$mapping = Mage::getModel('magebid/mapping')->load($transaction_shipping_method,'ebay');		
		
		if ($mapping->getMagento()) 
		{
			$code_array = explode("_",$mapping->getMagento());
			
			//Get CarrierName	
	        if ($name = Mage::getStoreConfig('carriers/'.$code_array[0].'/title')) {
	            $carrier_title = $name;
	        }
			else
			{
				$carrier_title = $code_array[0];
			}
			
			//Get Method Title
			 $className = Mage::getStoreConfig('carriers/'.$code_array[0].'/model');
			 if ($className)
			 {
		         $obj = Mage::getModel($className);
				 foreach ($obj->getAllowedMethods() as $key=>$method)
				 {
				 	if ($key==$code_array[1]) $method_title = $method;
				 }			 	
			 }		
			 if ($method_title=="")	$method_title = $code_array[1]; 
			
			//Build Data Array			
			$data = array(
				'code' => $mapping->getMagento(),
				'carrier' => $code_array[0],
				'method' => $code_array[1],
				'carrier_title' => $carrier_title,
				'method_title' => $method_title,				
				);					
			
			return $data;
		}
		else
		{
			return false;
		}		
	}
	
    /**
     * Check if a mapping for the payment method is existing
     * 
     * !Currently not used!
     * 
     * @return array|boolean 
     */		
	protected function _getMappedPaymentMethod($ebay_payment_method)
	{
			$mapping = Mage::getModel('magebid/mapping')->load($ebay_payment_method,'ebay');
			if ($mapping->getMagento())
			{
				return $mapping->getMagento();
			}	
			else
			{
				return false;
			}	
	}
	
}
?>
