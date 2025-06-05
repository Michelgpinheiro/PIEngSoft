<?php 

    class auction {

        // Attributes
        private $id;
        private $user_id;
        private $product_id;
        public $initial_date;
        public $final_date;
        public $auction_house_number;
        public $auction_house_reduction;
        public $auction_house_difference;
        public $increment_value;
        public $contact;
        public $observation;

        // Getters
        public function getId() { return $this->id; }
        public function getUserId() { return $this->user_id; }
        public function getProductId() { return $this->product_id; }

        // Setters
        public function setId($id) { $this->id = $id; }
        public function setUserId($user_id) { $this->user_id = $user_id; }
        public function setProductId($product_id) { $this->product_id = $product_id; }

    }

?>