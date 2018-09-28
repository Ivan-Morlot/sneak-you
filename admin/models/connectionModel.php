<?php
    class ConnectionModel
    {
        private $globalUtils;
        private $db;

        public function __construct($globalUtils) {
            $this->globalUtils = $globalUtils;
            $this->db = $this->globalUtils->initDb();
        }

        public function searchCreds($login, $password) {
            return $this->db->query("SELECT * FROM customer WHERE (email = '$login' AND password = '$password')");
        }
    }