<?php
/**
 * Netresearch_Magebid_Adminhtml_Templates_MainController
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Adminhtml_Templates_MainController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Main/Grid View
     *
     * @return void
     */	 
	public function indexAction()
    {
        $this->loadLayout()
           ->_addContent($this->getLayout()
                           ->createBlock('magebid/adminhtml_templates_main'))
            ->renderLayout();
			
    }
	
    /**
     * Create new item
     *
     * @return void
     */	
    public function newAction() // Create new element
    {

		$this->loadLayout()
        ->_addContent($this->getLayout()
           ->createBlock('magebid/adminhtml_templates_new'))
        ->renderLayout();
    }     

    /**
     * Post Action
     *
     * @return void
     */	 
    public function postAction() // Save element
    {
        
         if ($data = $this->getRequest()->getPost()) {
            $magebid = Mage::getModel('magebid/templates')->setData($data);
            try {
                $magebid->save();
                Mage::getSingleton('adminhtml/session')
                     ->addSuccess(Mage::helper('magebid')
                     ->__('Item was successfully saved'));
                $this->getResponse()->setRedirect($this->getUrl('*/*/'));
                return;
            } catch (Exception $e){
                die($e->getMessage());
                Mage::getSingleton('adminhtml/session')
                  ->addError($e->getMessage());
            }
        }
        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
        return;
        
    }
	
    /**
     * Edit View
     *
     * @return void
     */
	public function editAction()
	{
	    $this->loadLayout();
	    $this->_addContent($this->getLayout()
	       ->createBlock('magebid/adminhtml_templates_edit'));
	    $this->renderLayout();
	}
	
    /**
     * Save Item
     *
     * @return void
     */
	public function saveAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	    if ($data = $this->getRequest()->getPost())
		{
			$magebid = Mage::getModel('magebid/templates')->load($magebidId)->addData($data);
			  
	        try {
	            $magebid->setId($magebidId)->save();
	
	            Mage::getSingleton('adminhtml/session')
	               ->addSuccess(Mage::helper('magebid')
	               ->__('Content was saved successfully'));
	            $this->getResponse()->setRedirect($this->getUrl('*/*/'));
	            return;
	        } catch (Exception $e){
	            Mage::getSingleton('adminhtml/session')
	            ->addError($e->getMessage());
	        }
	    }
	    $this->_redirectReferer();
	}

    /**
     * Delete Item
     *
     * @return void
     */
	public function deleteAction()
	{
	    $magebidId = $this->getRequest()->getParam('id', false);
	
	    try {
	        Mage::getModel('magebid/templates')->setId($magebidId)->delete();
	        Mage::getSingleton('adminhtml/session')
	           ->addSuccess(Mage::helper('magebid')
	              ->__('Content successfully deleted'));
	        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
	
	        return;
	    } catch (Exception $e){
	        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	    }
	
	    $this->_redirectReferer();
	}		
}
?>