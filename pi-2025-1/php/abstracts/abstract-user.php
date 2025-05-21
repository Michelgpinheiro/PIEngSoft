<?php

    abstract class AbstractUser {

        // Attributes
        public $phone;
        public $address;
        public $neighborhood;
        public $number;
        public $uf;
        public $city;
        public $user_type;
        public $user_situation;
        private $id;
        private $email;
        private $password;
        
        // Getters
        public function getId() { return $this->id; }
        public function getEmail() { return $this->email; }
        public function getPassword() { return $this->password; }

        // Setters
        public function setId($id) { $this->id = $id; }
        public function setEmail($email) { $this->email = $email; }
        public function setPassword($password) { $this->password = $password; }
    }

?>


