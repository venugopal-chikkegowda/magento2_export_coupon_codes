<?php

namespace Codilar\MessageBlock\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
class Data extends AbstractHelper
{
	protected $_scopeConfig;
	public function __construct(
		ScopeConfigInterface $scopeConfig,
		Context $context
	) {
		$this->scopeConfig = $scopeConfig;
		parent::__construct($context);
	}

	public function getStaticData($id)
	{
		return $this->scopeConfig->getValue('homepage/Message_Block/'.$id, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function getBlogData($id)
	{
		return $this->scopeConfig->getValue('homepage/blog/'.$id, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function geFacebookBlockData($id)
	{
		return $this->scopeConfig->getValue('homepage/facebook_block/'.$id, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}

	public function geInstagramData($id)
	{
		return $this->scopeConfig->getValue('homepage/instagram_block/'.$id, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
}
