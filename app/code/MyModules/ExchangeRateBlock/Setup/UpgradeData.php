<?php

namespace MyModules\ExchangeRateBlock\Setup;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{
    private $blockFactory;
    const YOUR_STORE_ID = 1;

    public function __construct(BlockFactory $blockFactory)
    {
        $this->blockFactory = $blockFactory;
    }

    private function getData()
    {
        $url = "https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx";

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $content = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $xml = simplexml_load_string($content);

        return $xml;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = $this->getData();

        $setup->startSetup();


        $content = '
        <p>Cập nhật lúc: '. $data->DateTime .'</p>
        <table style="border-collapse: collapse; width: 100%;" border="1">
        <tbody>
        <tr>
            <td style="width: 565px; text-align: center; background-color: #005030; color: white;" colspan="2">Ngoại tệ</td>
            <td style="width: 564px; text-align: center; background-color: #005030; color: white;" colspan="2">Mua</td>
            <td style="width: 280px; text-align: center; background-color: #005030; color: white;" rowspan="2">Bán</td>
        </tr>
        <tr>
            <td style="width: 281px; text-align: center; background-color: #005030; color: white;">Mã ngoại tệ</td>
            <td style="width: 281px; text-align: center; background-color: #005030; color: white;">Tên ngoại tệ</td>
            <td style="width: 281px; text-align: center; background-color: #005030; color: white;">Tiền mặt</td>
            <td style="width: 280px; text-align: center; background-color: #005030; color: white;">Chuyển khoản</td>
        </tr>
        ';

        foreach ($data->Exrate as $Exrates) {
            $row = '<tr>
            <td style="width: 281px;">' . $Exrates['CurrencyCode'] . '</td>
            <td style="width: 281px;">' . $Exrates['CurrencyName'] . '</td>
            <td style="width: 281px;">' . $Exrates['Buy'] . '</td>
            <td style="width: 280px;">' . $Exrates['Transfer'] . '</td>
            <td style="width: 280px;">' . $Exrates['Sell'] . '</td>
        </tr>';
            $content = $content . $row;
        }

        $content = $content . '
                    </tbody>
                </table>';
        $cmsBlockData = [
            'title' => 'News',
            'identifier' => 'custom_cms_block',
            'content' => $content,
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];

        // run the code while upgrading module to version 0.1.1 
        if (version_compare($context->getVersion(), '0.1.1') < 0) {
            $cmsBlock = $this->_blockFactory->create()->setStoreId(self::YOUR_STORE_ID)->load('test-block', 'identifier');
 
            if (!$cmsBlock->getId()) {
                $this->_blockFactory->create()->setData($cmsBlockData)->save();
            } else {
                $cmsBlock->setContent($cmsBlockData['content'])->save(); 
            }
        }
 
        $setup->endSetup(); 

    }
}
