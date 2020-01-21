<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action{
        public function painel(){
            $this->validar();
            $this->validaKinesis();

            $this->render('/painel');
        }
        public function sair(){
            $this->validar();

            session_destroy();

            return header('location: /');
        }
        public function validaKinesis(){
            $kinesis = Container::getModel('Kinesis');

            $kinesis->__set('id_usuario', $_SESSION['id']);

            if(!$kinesis->validaKinesis()){
                $this->view->criarKinesis = True;
            }
        }
        public function addKinesis(){
            $this->validar();

            $kinesis = Container::getModel('Kinesis');

            $kinesis->__set('id_usuario', $_SESSION['id']);
            $kinesis->__set('_secundaria', $_POST['secundaria']);
            $kinesis->__set('primaria', $_POST['primaria']);
            $kinesis->addKinesis();

            header('location: /painel');
        }
        public function perfil(){
            $this->validar();

            $usuario = Container::getModel('Usuario');
            $kinesis = Container::getModel('Kinesis');

            $usuario->__set('id', $_SESSION['id']);
            $kinesis->__set('id_usuario', $_SESSION['id']);

            $usuario_kinesis = $kinesis->getAll();
            $this->view->primaria = $usuario_kinesis[0]['primaria'];
            array_shift($usuario_kinesis);
            $this->view->secundaria = $usuario_kinesis;

            
            $this->view->dados_usuario = $usuario->getAll();
            // $this->view->kinese = $kinesis->getAll();
            
            $this->render('perfil');
        }
        public function alterarDados(){
            $this->validar();

            $this->render('/alterar_dados');
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