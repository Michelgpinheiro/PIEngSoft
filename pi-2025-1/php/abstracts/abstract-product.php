<?php 

    abstract class AbstractProduct {

        // Attributes
        private $id;
        private $user_id;
        public $name;
        public $initial_auction_launch;
        public $addictional_data;
        public $mark;
        public $amount;

        // Getters
        public function getId() { return $this->id; }
        public function getUserId() { return $this->user_id; }

        // Setters
        public function setId($id) { $this->id = $id; }
        public function setUserId($user_id) { $this->user_id = $user_id; }

    }

?>