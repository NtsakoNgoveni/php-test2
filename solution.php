<?php

class Product {
    private $products;

    public function __construct($products) {
        $this->products = $products;
    }

    public function getProducts($newProducts) {
        $this->products = $newProducts;
    }
    public function get_product($productId){
        $productDetails = [];
        foreach ($this->products as $product) {
            if($product['id'] == $productId) {
                $productDetails = $product;
            }
        }
        return $productDetails;
    }
}

$products = [
    ['id' => 101, 'name' => 'Product 1', 'price' => 99.99],
    ['id' => 102, 'name' => 'Product 2', 'price' => 75.00],
    ['id' => 103, 'name' => 'Product 3', 'price' => 120.00],
];

$product = new Product($products);
print_r($product->get_product(101));
?>