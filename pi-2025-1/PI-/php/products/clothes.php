<?php 

    require_once __DIR__ . "/../abstracts/abstract-product.php";

    class Roupa extends AbstractProduct {

        // Attributes
        private $product_id;
        public $material;
        public $condition;
        public $size;
        public $color;
        public $style;

        // Getters
        public function getProductId() { return $this->product_id; }

        // Setters
        public function setProductId($product_id) { $this->product_id = $product_id; }

    }

?>