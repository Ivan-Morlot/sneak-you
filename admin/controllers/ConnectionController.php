<?php
    include 'models/ConnectionModel.php';
    include 'vues/ConnectionVue.php';

    class ConnectionController
    {
        private $globalUtils;
        private $model;
        private $vue;

        public function __construct($globalUtils) {
            $this->globalUtils = $globalUtils;
            $this->model = new ConnectionModel($this->globalUtils);
            $this->vue = new ConnectionVue();
        }

        public function createPage() {
            if(isset($_SESSION['auth_level']) && $_SESSION['auth_level'] == '1')
                $this->globalUtils->redirectTo("home.php"); // need refactoring

            if (isset($_POST['login']) && isset($_POST['password'])) {
                $login = $_POST['login'];
                $password = md5($_POST['password']);

                $req = $this->model->searchCreds($login, $password);
                if($user = $req->fetch(PDO::FETCH_ASSOC)) {
                    if($user['auth_level'] == '1') {
                        $_SESSION['login'] = $user['email'];
                        $_SESSION['auth_level'] = $user['auth_level'];
                        $this->globalUtils->redirectTo("home.php"); // need refactoring
                    } else
                        $this->vue->error = 'unauth';
                } else
                    $this->vue->error = 'badcreds';
            }

            $this->vue->display();
        }
    }