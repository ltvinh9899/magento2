<?php

namespace CustomModules\CurrencyRate\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Setup extends Template implements BlockInterface
{
    protected $_template = "widget/index.phtml";

    /**
     * Get currency rate data from Vietcombank
     */
    public function getCurrencyRateData(){
        $url = "https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx";

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $content = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $xml = simplexml_load_string($content);

        // return currency rate data
        return $xml;
    }
}
