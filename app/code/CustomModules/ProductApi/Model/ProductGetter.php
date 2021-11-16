<?php
namespace CustomModules\ProductApi\Model;

class ProductGetter
{
 /**
  * @var \Magento\Catalog\Api\ProductRepositoryInterface
  */
 protected $productRepository;

 public function __construct(
   \Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
 {
   $this->productRepository = $productRepository;
 }

 /**
  * {@inheritdoc}
  */
 public function getProductById($productId)
 {
   return $this->productRepository->getById($productId);
 }

 /**
  * {@inheritdoc}
  */
  public function getProductBySku($sku)
  {
    return $this->productRepository->get($sku);
  }
}