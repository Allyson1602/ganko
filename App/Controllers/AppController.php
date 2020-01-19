<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action{
        public function painel(){
            $this->validar();

            $this->render('/painel');
        }
        public function sair(){
            $this->validar();

            session_destroy();

            return header('location: /');
        }
        

        // VALIDA USUARIO
        public function validar(){
            session_start();

            if($_SESSION['id'] == ''){
                header('location: /?acessong=2');
            }
        }
        // VALIDA USUARIO
    }

?>