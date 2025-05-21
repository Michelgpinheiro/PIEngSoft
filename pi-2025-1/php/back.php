<?php 

    interface InterfaceUser {
        
        public function startAuction();
        public function auctionLaunch();
        public function registerPro();
        public function login();
        public function logout();
        public function checkAnalysisResult();
        public function checkAuctionResult();

    }

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

    class Admin extends AbstractUser implements InterfaceUser {

        // Attributes
        private $cpf;
        private $rg;
        public $name;

        // Getters
        public function getCpf() { return $this->cpf; }
        public function getRg() { return $this->rg; }

        // Setters
        public function setCpf($cpf) { $this->cpf = $cpf; }
        public function setRg($rg) { $this->rg = $rg; }

        // Interface methods
        public function startAuction() {

        }

        public function auctionLaunch() {

        }

        public function registerPro() {

        }

        public function login() {

        }

        public function logout() {

        }

        public function checkAnalysisResult() {

        }

        public function checkAuctionResult() {

        }

        // Class methods
        public function registerInterfaceUser() {

        }

        public function denyRequest() {

        }   

        public function approveRequest() {

        }

        public function suspendInterfaceUser() {

        }

        public function inactivateInterfaceUser() {

        }
    }

    class PhysicalPerson extends AbstractUser implements InterfaceUser {

        // Attributes
        private $cpf;
        private $rg;
        public $name;

        // Getters
        public function getCpf() { return $this->cpf; }
        public function getRg() { return $this->rg; }

        // Setters
        public function setCpf($cpf) { $this->cpf = $cpf; }
        public function setRg($rg) { $this->rg = $rg; }

        // Interface methods
        public function startAuction() {

        }

        public function auctionLaunch() {

        }

        public function registerPro() {

        }

        public function login() {

        }

        public function logout() {

        }

        public function checkAnalysisResult() {

        }

        public function checkAuctionResult() {

        }

        // class Methods
        //    ------
    }

    class LegalEntity extends AbstractUser implements InterfaceUser {

        // Attributes
        private $cnpj;
        public $corporate_reason;
        public $business_name;

        // Getter
        public function getCnpj() { return $this->cnpj; }

        // Setter
        public function setCnpj($cnpj) { $this->cnpj = $cnpj; }

        // Interface methods
        public function startAuction() {

        }

        public function auctionLaunch() {

        }

        public function registerPro() {

        }

        public function login() {

        }

        public function logout() {

        }

        public function checkAnalysisResult() {

        }

        public function checkAuctionResult() {

        }
    }

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

    class Others extends AbstractProduct {

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