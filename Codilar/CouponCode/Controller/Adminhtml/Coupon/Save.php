<?php
namespace Codilar\CouponCode\Controller\Adminhtml\Coupon;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $_directoryList;
    /**
     * @var \Magento\SalesRule\Model\CouponFactory
     */
    protected $_couponFactory;
    public function __construct(
        Context $context,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list,
        \Magento\SalesRule\Model\CouponFactory $couponFactory
    )
    {
        $this->_directoryList = $directory_list;
        $this->_couponFactory = $couponFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $coupons = $this->getRequest()->getParam('coupon');
        $couponIds = explode(',',$coupons);
        if (!file_exists($this->_directoryList->getRoot().'/pub/media/couponcode')) {
            mkdir($this->_directoryList->getRoot().'/pub/media/couponcode', 0777, true);
        }
        date_default_timezone_set('Asia/Kolkata');
        $couponCollection = $this->_couponFactory->create()->getCollection();
        $heading = [
            __('Coupon Id'),
            __('Rule Id'),
            __('Code'),
            __('Usage Limit'),
            __('Usage Per Customer'),
            __('Times Used'),
            __('Expiration Date'),
            __('Is Primary'),
            __('Type')
        ];
        $todayDate = date('Y_m_d_H_i_s', time());
        $outputFile = $this->_directoryList->getRoot().'/pub/media/couponcode/couponcode_'.$todayDate.'.csv';
        $handle = fopen($outputFile, 'w');
        fputcsv($handle, $heading);
        foreach ($couponCollection as $coupon) {
            if (in_array($coupon->getCouponId(), $couponIds)){
                $row = [
                $coupon->getCouponId(),
                $coupon->getRuleId(),
                $coupon->getCode(),
                $coupon->getUsageLimit(),
                $coupon->getUsagePerCustomer(),
                $coupon->getTimesUsed(),
                $coupon->getExpirationDate(),
                $coupon->getIsPrimary(),
                $coupon->getType()
            ];
            fputcsv($handle, $row);
            }
            
        }
        $this->downloadCsv($outputFile);
        //$this->messageManager->addSuccessMessage("Couponcodes Exported Succesfully");
    }

    public function downloadCsv($file)
    {
        if (file_exists($file)) {
            //set appropriate headers
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();flush();
            readfile($file);
        }
    }
}