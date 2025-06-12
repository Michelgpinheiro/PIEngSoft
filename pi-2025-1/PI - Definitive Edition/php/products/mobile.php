<?php 

    require_once __DIR__ . "/../abstracts/abstract-product.php";

    class Mobile extends AbstractProduct {

        // Attributes
        private $product_id;
        public $material;
        public $condition;
        public $dimention;
        public $color;

        // Getter
        public function getProductId() { return $this->product_id; }

        // Setter
        public function setProductId($product_id) { $this->product_id = $product_id; }

    }

?>