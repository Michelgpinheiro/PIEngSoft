<?php 

    require_once __DIR__ . "/../abstracts/abstract-product.php";

    class Vehicle extends AbstractProduct {

        // Attributes
        private $product_id;
        public $model;
        public $plate;
        public $mileage;
        public $manufacture_year;
        public $color;

        // Getter
        public function getProductId() { return $this->product_id; }

        // Setter
        public function setProductId($product_id) { $this->product_id = $product_id; }

    }

?>