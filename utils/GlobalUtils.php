<?php
    class GlobalUtils
    {
        private $db;

        public function __construct()
        {
            $this->db = null;
        }

        public function initDb()
        {
            try {
                $this->db = new PDO("mysql:host=localhost;dbname=db_boutique;charset=utf8", "root", "");
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->db;
            } catch (PDOException $e) {
                require "../404.php";
            }
        }

        public function logoutAndAutoRedirect()
        {
            if(isset($_SESSION['auth_level']))
                $authLevel = $_SESSION['auth_level'];

            session_destroy();

            if($authLevel == 1)
                $loc = '..\admin\index.php';
            else
                $loc = '..\index.php';

            redirectTo($loc);
        }

        public function adminCheckAndAutoRedirectIfUser()
        {
            if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] != 1 || !isset($_SESSION['auth_level']))
                redirectTo("..\index.php");
        }
        
        public function redirectTo($location) {
            header("location:".$location);
        }
    }