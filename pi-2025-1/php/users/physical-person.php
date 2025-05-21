<?php 

    require_once __DIR__ . "/../abstracts/abstract-user.php";
    require_once __DIR__ . "/../interfaces/interface-user.php";

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

?>