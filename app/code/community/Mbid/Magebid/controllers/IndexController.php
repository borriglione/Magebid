<?php
/**
 * Mbid_Magebid_IndexController
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    Andreas Plieninger <info@plieninger.org>
 * @copyright 2010 Andreas Plieninger
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_IndexController extends Mage_Core_Controller_Front_Action
{
    public function listenAction()
    {
		$Notification = Mage::getModel('magebid/notification');
		$Notification->handleNotification();
		die('fuck');
    }
}