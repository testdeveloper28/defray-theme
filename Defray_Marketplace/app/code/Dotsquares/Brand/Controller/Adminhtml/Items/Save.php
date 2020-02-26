<?php

namespace Dotsquares\Brand\Controller\Adminhtml\Items;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Dotsquares\Brand\Controller\Adminhtml\Items
{
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
				$model = $this->_objectManager->create('Dotsquares\Brand\Model\Brands');
				$data = $this->getRequest()->getPostValue();
				$inputFilter = new \Zend_Filter_Input(
                    [],
                    [],
                    $data
                );
                $data = $inputFilter->getUnescaped();
                $id = $this->getRequest()->getParam('brand_id');
				
                if ($id) {
                    $model->load($id);
                    if ($id != $model->getId()) {
                        throw new \Magento\Framework\Exception\LocalizedException(__('The wrong item is specified.'));
                    }
                }else{
					$option_value[] = $data['name'];
				    $option_value[] = $data['optionlabel'];
				    //$attribute = $this->_objectManager->create('Magento\Eav\Model\Entity\Attribute');
				    $attr = $this->_objectManager->create('\Magento\Eav\Model\Entity\Attribute'); 
				    $attributeId = $attr->getIdByCode('catalog_product','brand');
				    $attr->load($attributeId); 
				    $option = [];
				    $option['value'][$option_value[0]] = $option_value; 
				    $attr->addData(array('option' => $option));
				    $attr->save();
				}
				
				/****************************start image save ****************************/	
				
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
						$uploader->addValidateCallback('brand_image', $imageAdapter, 'validateUploadFile');
						$uploader->setAllowRenameFiles(true);
						$uploader->setFilesDispersion(true);

						/** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
						$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
							->getDirectoryRead(DirectoryList::MEDIA);
						
						$result = $uploader->save(
							$mediaDirectory->getAbsolutePath('brand')
						);

						$data['filename'] = 'brand/'.$result['file'];
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
				
				
				
				/****************************end image save ****************************/
				
                $model->setData($data);
                $session = $this->_objectManager->get('Magento\Backend\Model\Session');
                $session->setPageData($model->getData());
                $model->save();
                $this->messageManager->addSuccess(__('You saved the item.'));
                $session->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('brand/*/edit', ['id' => $model->getId()]);
                    return;
                }
                $this->_redirect('brand/*/');
                return;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('id');
                if (!empty($id)) {
                    $this->_redirect('brand/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('brand/*/new');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the item data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $this->_redirect('brand/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('brand/*/');
    }
}
