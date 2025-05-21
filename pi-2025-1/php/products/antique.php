<?php 

    require_once __DIR__ . "/../abstracts/abstract-product.php";

    class Antique extends AbstractProduct {

        // Attributes
        private $product_id;
        public $material;
        public $condition;
        public $manufacture_year;
        public $dimention;

        // Getters
        public function getProductId() { return $this->product_id; }

        // Setters
        public function setProductId($product_id) { $this->product_id = $product_id; }
    }

?>