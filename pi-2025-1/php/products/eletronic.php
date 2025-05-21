<?php 

    require_once __DIR__ . "/../abstracts/abstract-product.php";

    class Eletronic extends AbstractProduct {

        // Attributes
        private $product_id;
        public $model;
        public $condition;

        // Getter
        public function getProductId() { return $this->product_id; }

        // Setter
        public function setProductId($product_id) { $this->product_id = $product_id; }

    }

?>