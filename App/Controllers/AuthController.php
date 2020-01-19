<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AuthController extends Action{
        // AUTENTICAR
        public function autenticar(){
            session_start();

            $usuario = Container::getModel('Usuario');

            $usuario->__set('nick', $_POST['login']);
            $usuario->__set('email', $_POST['login']);
            $usuario->__set('senha', md5($_POST['senha']));

            $log = $usuario->autenticar();

            if($log != ''){
                $_SESSION['id'] = $log['id'];
                $_SESSION['nick'] = $log['nick'];
                $_SESSION['email'] = $log['email'];

                header('location: /painel');
            }else{
                header('location: /?log=1');
            }
        }
        // AUTENTICAR
    }

?>