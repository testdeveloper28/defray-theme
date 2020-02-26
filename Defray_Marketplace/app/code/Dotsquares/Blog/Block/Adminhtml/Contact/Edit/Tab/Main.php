<?php
namespace Dotsquares\Blog\Block\Adminhtml\Contact\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;

    /**
    * @var \Webspeaks\ProductsGrid\Helper\Data $helper
    */
    protected $helper;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Dotsquares\Blog\Helper\Data $helper,
        \Dotsquares\Blog\Model\Status $options,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Webspeaks\ProductsGrid\Model\Contact */
		$wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]); 
        $model = $this->_coreRegistry->registry('ws_contact');
		#print_r($model->getData());die("tets");
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('contact_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Contact Information')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Blog Title'), 'title' => __('Blog Title'), 'required' => true]
        );
		
		$fieldset->addField(
            'logo',
            'image',
            ['name' => 'logo', 'label' => __('Blog Small Image'), 'title' => __('Blog Small Image'), 'required' => false]
        );
		
        $fieldset->addField(
            'filename',
            'editor',
            ['name' => 'filename', 'label' => __('Content'), 'title' => __('Large Image'),
			'required' => true,
			'config' => $wysiwygConfig,
			'note' => 'Allow image type: jpg, jpeg, gif, png']
        );
        $fieldset->addField(
            'short_description',
            'textarea',
            ['name' => 'short_description', 'label' => __('Short Description'), 'title' => __('Short Description'),
			'required' => true]
        );
		
		$fieldset->addField(
            'description',
            'textarea',
            ['name' => 'description', 'label' => __('Description'), 'title' => __('Description'),
			'required' => true]
        );
		$fieldset->addField(
            'devloper',
            'text',
            ['name' => 'devloper', 'label' => __('Devloper by'), 'title' => __('Devloper by'),
			'required' => true]
        );
		
        
		
		$fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
				'values' => $this->_options->getOptionArray(),
            ]
        );
		if($model->getData('logo')){
            $model->setData('logo',$model->getLogo());
        }
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Main');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Main');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
