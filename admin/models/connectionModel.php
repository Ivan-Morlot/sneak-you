<?php
    class ConnectionModel
    {
        private $db;

        public function ConnectionModel($db) {
            $this->db = $db;
        }

        public function searchCreds($login, $password) {
            return $this->db->query("SELECT * FROM customer WHERE (email = '$login' AND password = '$password')");
        }
        
        public function redirectToHome() {
            header("location:home.php");
        }
    }
