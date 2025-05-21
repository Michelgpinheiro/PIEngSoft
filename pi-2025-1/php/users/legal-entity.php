<?php 

    require_once __DIR__ . "/../abstracts/abstract-user.php";
    require_once __DIR__ . "/../interfaces/interface-user.php";

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

?>