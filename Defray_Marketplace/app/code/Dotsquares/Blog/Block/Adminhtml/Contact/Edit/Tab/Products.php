<?php

namespace Dotsquares\Blog\Block\Adminhtml\Contact\Edit\Tab;

use Dotsquares\Blog\Model\ContactFactory;

class Products extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $productCollectionFactory;
    protected $contactFactory;
    protected $reviewFactory;
    protected $registry;
    protected $_objectManager = null;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        ContactFactory $contactFactory,
        \Dotsquares\Blog\Model\Status $options,
        \Dotsquares\Blog\Model\ResourceModel\Review\CollectionFactory $reviewFactory,
        array $data = []
    ) {
        $this->contactFactory = $contactFactory;
        $this->reviewFactory = $reviewFactory;
        $this->_options = $options;
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('creviewGrid');
        $this->setDefaultSort('blogid');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
		$this->setFilterVisibility(false);
		if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('in_product' => 1));
        }
    }

    protected function _addColumnFilterToCollection($column)
    {
		$current_id = $this->getRequest()->getParam('id');
		if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('blogid', array('in' => $current_id));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('blogid', array('nin' => $current_id));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = $this->reviewFactory->create();
		$this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $model = $this->_objectManager->get('\Dotsquares\Blog\Model\Contact');
        $this->addColumn(
            'in_product',
            [
				'header' => __('Review ID'),
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_product',
                'align' => 'center',
                'index' => 'reviewid',
                'values' => $this->_getSelectedProducts(),
            ]
        );
        $this->addColumn(
            'customername',
            [
				'header' => __('Customer Name'),
                'header_css_class' => 'a-center',
                'type' => 'text',
                'align' => 'center',
                'index' => 'customername',
            ]
        );
        $this->addColumn(
            'customeremail',
            [
				'header' => __('Customer Email'),
                'header_css_class' => 'a-center',
                'type' => 'text',
                'align' => 'center',
                'index' => 'customeremail',
            ]
        );

        $this->addColumn(
            'comment',
            [
				'header' => __('Comment'),
                'header_css_class' => 'a-center',
                'type' => 'text',
                'align' => 'center',
                'index' => 'comment',
            ]
        );
        $this->addColumn(
            'Status',
            [
				'header' => __('Current Status'),
                'header_css_class' => 'a-center',
                'type' => 'text',
                'name' => 'status',
                'align' => 'center',
                'index' => 'status',
				'renderer' => 'Dotsquares\Blog\Block\Adminhtml\Contact\Grid\Renderer\Status',
				#'values' => $this->getstatus('status'),
            ]
        );
		$this->addColumn(
            'update',
            [
				'header' => __('Update'),
                'header_css_class' => 'a-center',
                'type' => 'text',
                'name' => 'in_product',
                'align' => 'center',
                'index' => 'in_product',
				#'url'   => $this->getUrl('*/*/update', array('_current' => true)),
				#'class'     => 'ajax',
				'renderer' => 'Dotsquares\Blog\Block\Adminhtml\Contact\Grid\Renderer\Action',
            ]
        );
		/* $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'type' => 'text',
                'width' => '50px',
				'renderer'=> '\Dotsquares\Blog\Block\Adminhtml\Contact\Grid\Renderer\Position',
				'index'=>'entity_id',

            ]
        ); */
        return parent::_prepareColumns();
    }
   
    public function getGridUrl()
    {
        return $this->getUrl('*/*/creviewgrid', ['_current' => true]);
    }

    public function getRowUrl($row)
    {
        return '';
    }

    protected function _getSelectedProducts()
    {
        $contact = $this->getContact();
		#echo '<pre>';print_r($contact->getData());
        return $contact->getCustomerReview($contact);
    }

    public function getSelectedProducts()
    {
        $contact = $this->getContact();
        $selected = $contact->getProducts($contact);
		#print_r($selected);
        if (!is_array($selected)) {
            $selected = [];
        }
        return $selected;
    }

    protected function getContact()
    {
        $contactId = $this->getRequest()->getParam('id');
        $contact   = $this->contactFactory->create();
        if ($contactId) {
            $contact->load($contactId);
        }
        return $contact;
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return true;
    }
	
}