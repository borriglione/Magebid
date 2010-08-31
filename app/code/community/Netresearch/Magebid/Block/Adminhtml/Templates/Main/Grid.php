<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Templates_Main_Grid
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Templates_Main_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Construct
     *
     * @return void
     */		
     public function __construct()
    {
        parent::__construct();
        $this->setId('magebidGrid');
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
        $model = Mage::getModel('magebid/templates');
        $collection = $model->getCollection();		    
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }
	
    /**
     * Prepare Columns
     *
     * @return object
     */	
    protected function _prepareColumns()
    {

        $this->addColumn('magebid_templates_id', array(
            'header'        => Mage::helper('magebid')->__('ID'),
            'align'         => 'right',
            'width'         => '50px',
            'filter_index'  => 'magebid_templates_id',
            'index'         => 'magebid_templates_id',
        ));

        $this->addColumn('content_name', array(
            'header'        => Mage::helper('magebid')->__('Title'),
            'align'         => 'left',
            'width'         => '150px',
            'filter_index'  => 'content_name',
            'index'         => 'content_name',
        ));

        $this->addColumn('content_type', array(
            'header'        => Mage::helper('magebid')->__('Type'),
            'align'         => 'left',
            'width'         => '150px',
            'index'         => 'content_type',
			'filter_index'  => 'content_type',
            'type'          => 'text',
            'escape'        => true,
        ));
		
        $this->addColumn('date_created', array(
            'header'        => Mage::helper('magebid')->__('Date Created'),
            'align'         => 'left',
            'filter_index'  => 'date_created',
            'index'         => 'date_created',
            'type'          => 'datetime',
        ));		


        $this->addColumn('  	date_modified', array(
            'header'        => Mage::helper('magebid')->__('Last Modified'),
            'align'         => 'left',
            'filter_index'  => 'date_modified',
            'index'         => 'date_modified',
            'type'          => 'datetime',
        ));
		
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('magebid')->__('Action'),
                'width'     => '150px',
                'type'      => 'action',
                'getter'	=> 'getMagebidTemplatesId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('magebid')->__('Edit'),
                        'url'     => array(
                            'base'=>'*/*/edit'
                         ),
                         'field'   => 'id'
                    ),
                    array(
                        'caption' => Mage::helper('magebid')->__('Delete'),
                        'url'     => array(
                            'base'=>'*/*/delete'
                         ),
                         'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false
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
            'id' => $row->getMagebidTemplatesId(),
        ));
    }
}
?>
