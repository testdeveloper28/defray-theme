<?php
namespace Dotsquares\Homepageslider\Controller\Adminhtml\Items;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Dotsquares\Homepageslider\Controller\Adminhtml\Items
{
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try
			{
                $model = $this->_objectManager->create('Dotsquares\Homepageslider\Model\Items');
                $data = $this->getRequest()->getPostValue();
                $inputFilter = new \Zend_Filter_Input(
                    [],
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();
                $id = $this->getRequest()->getParam('id');
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                }
				if (isset($_FILES['filename']) && isset($_FILES['filename']['name']) && strlen($_FILES['filename']['name']))
				{
					/* * Save image upload */
					try
					{
						$uploader = $this->_objectManager->create(
							'Magento\MediaStorage\Model\File\Uploader',
							['fileId' => 'filename']
						);
						$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
						/** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
						$imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
						$uploader->addValidateCallback('slider_image', $imageAdapter, 'validateUploadFile');
						$uploader->setAllowRenameFiles(true);
						$uploader->setFilesDispersion(true);

						/** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
						$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
							->getDirectoryRead(DirectoryList::MEDIA);
						$result = $uploader->save(
							$mediaDirectory->getAbsolutePath('slider')
						);

						$data['filename'] = 'slider'.$result['file'];
					} catch (\Exception $e) {
						if ($e->getCode() == 0) {
							$this->messageManager->addError($e->getMessage());
						}
					}
				}
				else
				{
					if ($id  && $model->getFilename() == '' ) {
						 throw new \Magento\Framework\Exception\LocalizedException(__('Image is required.'));
					}else if(isset($data['filename']['delete'])){
						$data['filename'] = '';
					}else{
     					$data['filename'] = $data['filename']['value'];
					}
				}
                $model->setData($data);
                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $model->save();
                $this->messageManager->addSuccess(__('You saved the item.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('dotsquares_homepageslider/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('dotsquares_homepageslider/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('id');
                if (!empty($id)) {
                    $this->_redirect('dotsquares_homepageslider/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('dotsquares_homepageslider/*/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('dotsquares_homepageslider/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('dotsquares_homepageslider/*/');
    }
}
