<?php
namespace CustomModules\ProductApi\Api;

interface ProductGetterInterface
{
 /**
  * GET product identified by its id
  *
  * @api
  * @param int $productId
  * @return \Magento\Catalog\Api\Data\ProductInterface
  * @throws \Magento\Framework\Exception\NoSuchEntityException
  */
 public function getProductById($productId);
 
/**
  * GET product identified by its sku
  *
  * @api
  * @param string $sku
  * @return \Magento\Catalog\Api\Data\ProductInterface
  * @throws \Magento\Framework\Exception\NoSuchEntityException
  */
  public function getProductBySku($sku);

}
