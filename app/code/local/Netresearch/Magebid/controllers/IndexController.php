<?php
class Netresearch_Magebid_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
	    $this->loadLayout();
        $this->getLayout()->getBlock('root')->setTemplate("page/3columns.phtml");
	    $this->getLayout()->getBlock('content')->append($this->getLayout()->createBlock('magebid/index'));
        $this->renderLayout();
    }
}
?>