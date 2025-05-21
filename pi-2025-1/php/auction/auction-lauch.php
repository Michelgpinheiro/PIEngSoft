<?php 

    class auctionLaunch {
            
        // Attributes
        private $id;
        private $user_id;
        private $auction_id;
        public $value;
        public $contact;
        public $observation;

        // Getters
        public function getId() { return $this->id; }
        public function getUserId() { return $this->user_id; }
        public function getAuctionId() { return $this->auction_id; }

        // Setters
        public function setId($id) { $this->id = $id; }
        public function setUserId($user_id) { $this->user_id = $user_id; }
        public function setAuctionId($auction_id) { $this->auction_id = $auction_id; }
    }

?>