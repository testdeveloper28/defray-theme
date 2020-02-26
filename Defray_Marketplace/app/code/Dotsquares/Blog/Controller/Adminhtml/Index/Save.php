<?php

namespace Dotsquares\Blog\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;

class Save extends \Magento\Backend\App\Action
{
    protected $_jsHelper;
	
	protected $_contactCollectionFactory;
	
	public function __construct(
        Context $context,
        \Magento\Backend\Helper\Js $jsHelper,
        \Dotsquares\Blog\Model\ResourceModel\Contact\CollectionFactory $contactCollectionFactory
    ) {
        $this->_jsHelper = $jsHelper;
        $this->_contactCollectionFactory = $contactCollectionFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
		$resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Webspeaks\ProductsGrid\Model\Contact $model */
            $model = $this->_objectManager->create('Dotsquares\Blog\Model\Contact');

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
				if ($id != $model->getId()) {
					throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
				}
            }
			if (isset($_FILES['logo']) && isset($_FILES['logo']['name']) && strlen($_FILES['logo']['name']))
			{
				try
				{
					$uploader = $this->_objectManager->create(
						'Magento\MediaStorage\Model\File\Uploader',
						['fileId' => 'logo']
					);
					$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
					$imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
					$uploader->addValidateCallback('blog_image', $imageAdapter, 'validateUploadFile');
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);
					$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
						->getDirectoryRead(DirectoryList::MEDIA);
					$result = $uploader->save(
						$mediaDirectory->getAbsolutePath('blog')
					);
					$data['logo'] = 'blog'.$result['file'];
				} catch (\Exception $e) {
					if ($e->getCode() == 0) {
						$this->messageManager->addError($e->getMessage());
					}
				}
			}else{
				if ($id  && $model->getFilename() == '' ) {
				    throw new \Magento\Framework\Exception\LocalizedException(__('Image is required.'));
				}else if(isset($data['logo']['delete'])){
					$data['logo'] = '';
				}else{
     				$data['logo'] = $data['logo']['value'];
				}
				
			}
			$model->setData($data);
			$this->saveProducts($model, $data);
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this blog.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the blog.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

	public function saveProducts($model, $post)
    {
		#echo '<pre>';print_r($model->getData());
		if (isset($post['Customer_Reviews'])) {
            $ReviewIds = $this->_jsHelper->decodeGridSerializedInput($post['Customer_Reviews']);
			#$postion = $post['position'];
            try {
                $oldProducts = (array) $post['Customer_Reviews'];
                $newProducts = (array) $ReviewIds;
				#echo '<pre>';print_r($oldProducts);print_r($newProducts); die('helo')	;
                $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();
                $table = $this->_resources->getTableName('blog_review_position');
                $insert = $newProducts;
                $delete = $oldProducts;
				if ($delete) {
					foreach($delete as $key){
						$where = ['blogid = ?' => (int)$model->getId()];
						$connection->delete($table, $where);
					}
                }
				if ($insert) {
                    $data = [];
                    foreach ($insert as $Review_Id) {
						$data[] = ['blogid' => (int)$model->getId(), 'reviewid' => (int)$Review_Id];
					}
                    $connection->insertMultiple($table, $data);
                }
			} catch (Exception $e) {
               $this->messageManager->addException($e, __('Something went wrong while saving the contact.'));
            }
        }
	}
}