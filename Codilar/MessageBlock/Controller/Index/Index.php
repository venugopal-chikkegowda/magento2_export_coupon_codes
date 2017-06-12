<?php
/**
 *
 * Copyright © 2015 Codilarcommerce. All rights reserved.
 */
namespace Codilar\MessageBlock\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Index constructor.
     * @param Context $context
     */
    public function __construct(
       Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.trello.com/1/boards?name=sample&desc=test&defaultLists=false&defaultLabels=false&key=8a57f2b161aa7f876295561ddc72607f&token=9b9a45c50344a79aa50ee90eba9aa50eea8cca0b6877df738903725d6a3d5875",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 9020c3a9-c54f-da5a-d100-d3df94e8ccc0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        print_r($response);die;
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }

}
