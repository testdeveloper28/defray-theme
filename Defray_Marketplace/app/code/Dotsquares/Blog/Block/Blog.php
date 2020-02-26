<?php
namespace Dotsquares\Blog\Block;

use Dotsquares\Blog\Model\ContactFactory;
use Dotsquares\Blog\Model\ReviewFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Filesystem\DirectoryList;

class Blog extends \Magento\Framework\View\Element\Template
{
	protected $connection;
    protected $resource; 
	protected $_objectManager;
	protected $blod_collection;
	protected $_filterProvider;
	protected $_filesystem;
    protected $_storeManager;
    protected $_directory;
    protected $_directoryList;
	
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		ContactFactory $blogFactory,
		DirectoryList $directoryList,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
		ReviewFactory $reviewFactory,
		\Magento\Cms\Model\Template\FilterProvider $filterProvider,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Framework\App\ResourceConnection $resource,
        array $data = []
	)
	{
		$this->_resource = $resource;
		$this->_blogFactory = $blogFactory;
		$this->_reviewFactory = $reviewFactory;
		$this->_filterProvider = $filterProvider;
		$this->_objectManager = $objectManager;
		$this->_directoryList = $directoryList;
		$this->_filesystem = $filesystem;
        $this->_storeManager = $storeManager;
        $this->_directory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_imageFactory = $imageFactory;
		parent::__construct($context, $data);
	}
	
	public function getBlogCollection()
	{
		$collection = $this->_blogFactory->create()->getCollection();
		$collection->addFieldToFilter('status',1);
		return $collection;
	}
	public function getReviewCollection()
	{
		$id = $this->getRequest()->getParams();
		$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
        $connection = $this->_resources->getConnection();
        $table = $this->_resources->getTableName('blog_review');
		$select = $this->getConnection()->select()->from(
            $table,
            ['reviewid']
        )
        ->where(
            'blogid = ?',
            (int)$id
        );
		$review_id = $this->getConnection()->fetchCol($select);
		$collection = $this->_reviewFactory->create()->getCollection();
		$collection->addFieldToFilter('blogid', array('in' => $id));
		//$collection->addFieldToFilter('reviewid', array('in' => $review_id));
		$collection->addFieldToFilter('status',1);
		return $collection;
	}
	
	public function getBlogLoad()
	{
		$id = $this->getRequest()->getParam('id');
		$collection = $this->_objectManager->create('Dotsquares\Blog\Model\Contact')->load($id);
		return $collection;
	}
	
	public function getCmsFilterContent($value='')
    {
        $html = $this->_filterProvider->getPageFilter()->filter($value);
        return $html;
    }
	public function getImageMediaPath(){
    	return $this->getUrl('pub/media',['_secure' => $this->getRequest()->isSecure()]);
    }
	
	public function getConnection()
    {
        $connection = $this->_resource->getConnection('core_write');
        return $connection;
    }
	public function getsidebarimageResize($src,$width,$height,$dir=''
	){
		$absPath = $this->_filesystem
		->getDirectoryRead(DirectoryList::MEDIA)
		->getAbsolutePath().'blog'.$src;
		$imageResized = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath($dir).$this->getSideNewDirectoryImage($src);
        $imageResize = $this->_imageFactory->create();
        $imageResize->open($absPath);
        $imageResize->constrainOnly(false);
        $imageResize->keepTransparency(false);
        $imageResize->keepFrame(false);
        $imageResize->keepAspectRatio(false);
        $imageResize->resize($width,$height);
        $dest = $imageResized ;
		$imageResize->save($dest);
        $resizedURL= $this->_storeManager->getStore()
		->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).
		$dir.$this->getSideNewDirectoryImage($src);
		return $resizedURL;
    }

    public function getSideNewDirectoryImage($src){
        $segments = array_reverse(explode('/',$src));
        $first_dir = substr($segments[0],0,1);
        $second_dir = substr($segments[0],1,1);
		return 'cache/'.$first_dir.'/'.$second_dir.'/'.$segments[0];
    }
	public function getimageResize($src,$width,$height,$dir='blog/'
	){
		$absPath = $this->_filesystem
		->getDirectoryRead(DirectoryList::MEDIA)
		->getAbsolutePath().$src;
		$imageResized = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath($dir).$this->getNewDirectoryImage($src);
        $imageResize = $this->_imageFactory->create();
        $imageResize->open($absPath);
        $imageResize->constrainOnly(false);
        $imageResize->keepTransparency(false);
        $imageResize->keepFrame(false);
        $imageResize->keepAspectRatio(false);
        $imageResize->resize($width,$height);
        $dest = $imageResized;
		$imageResize->save($dest);
        $resizedURL = $this->_storeManager->getStore()
		->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).
		$dir.$this->getNewDirectoryImage($src);
		return $resizedURL;
    }

    public function getNewDirectoryImage($src){
        $segments = array_reverse(explode('/',$src));
		$first_dir = substr($segments[0],0,1);
        $second_dir = substr($segments[0],2,2);
		return 'cache/'.$first_dir.'/'.$second_dir.'/'.$segments[0];
    }
	
}
