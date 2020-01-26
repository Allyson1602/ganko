<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action{
        public function painel(){
            $this->validar();
            $this->validaKinesis();
            $this->validaFoto();

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
            
            $this->view->criarKinesis = True;

            if(count($kinesis->validaKinesis())){
                $this->view->criarKinesis = False;
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
            
            $this->render('perfil');
        }
        public function alterarDados(){
            $this->validar();

            $usuario = Container::getModel('Usuario');
            $kinesis = Container::getModel('kinesis');

            $usuario->__set('id', $_SESSION['id']);
            $this->view->usuario = $usuario->getAll();

            $kinesis->__set('id_usuario', $_SESSION['id']);
            $this->view->kinesis_alt = $kinesis->getAll();

            $this->render('/alterar_dados');
        }
        public function editarDados(){
            $this->validar();
			$usuario = Container::getModel('Usuario');
            $kinesis = Container::getModel('Kinesis');

            $kinesis->__set('id_usuario', $_SESSION['id']);
            $kinesis->__set('_secundaria', $_POST['secundaria']);
            $kinesis->__set('primaria', $_POST['primaria']);

            // remove kinesis existentes
            $kinesis->rmKinesis();
            // adiciona novas kinesis
            $kinesis->addKinesis();
            
            // FORMATO DE ARQUIVO
            $extensao = $_FILES['foto']['type'];
            if($extensao != 'image/jpg' && $extensao != 'image/png' && $extensao != 'image/jpeg'){
                header('location: /painel?stt_upload=formato_bloqueado');
            }
            // LIMITE DE TAMANHO DO ARQUIVO
            if($_FILES['foto']['size'] > 500000){
                header('location: /painel?stt_upload=tamanho_exedido');
            }
            // MOVE ARQUIVOS PARA A PASTA IMG
            move_uploaded_file($_FILES['foto']['tmp_name'], 'img/'.$_FILES['foto']['name']);

            $usuario->__set('foto', $_FILES['foto']['name']);
			$usuario->__set('nascimento', $_POST['nascimento']);
			$usuario->__set('genero', $_POST['genero']);
			$usuario->__set('comeco', $_POST['comeco']);
			$usuario->__set('nick', $_POST['login']);
            $usuario->__set('email', $_POST['email']);
            $usuario->__set('id', $_SESSION['id']);

			$this->view->loginExiste = false;
			$this->view->emailExiste = false;

			if(count($usuario->nickExiste()) != 0){
                return header('location: /alterar_dados?msg=nickExiste');
			}
			if(count($usuario->emailExiste()) != 0){
                return header('location: /alterar_dados?msg=emailExiste');
            }

            // DELETA O ARQUIVO DA IMAGEM
            unlink("img/".$usuario->validaFoto()['foto']);
            
            $usuario->editarDados();

            return header('location: /perfil?msg=dadosAlt');
        }
        public function deletarConta(){
            $this->validar();

            $usuario = Container::getModel('Usuario');
            $kinesis = Container::getModel('Kinesis');

            $usuario->__set('id', $_SESSION['id']);
            $usuario->deletarConta();

            $kinesis->__set('id_usuario', $_SESSION['id']);
            $kinesis->rmKinesis();

            header('location: /?msg=deletada');
        }
        public function validaFoto(){
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
            
            $this->view->validaFoto = True;

            if(count($usuario->validaFoto()) == 1){
                $this->view->validaFoto = False;
            }
        }
        public function addImagem(){
            $this->validar();

            // FORMATO DE ARQUIVO
            $extensao = $_FILES['foto']['type'];
            if($extensao != 'image/jpg' && $extensao != 'image/png' && $extensao != 'image/jpeg'){
                header('location: /painel?stt_upload=formato_bloqueado');
            }
            // LIMITE DE TAMANHO DO ARQUIVO
            if($_FILES['foto']['size'] > 500000){
                header('location: /painel?stt_upload=tamanho_exedido');
            }

            // MOVE ARQUIVOS PARA A PASTA IMG
            move_uploaded_file($_FILES['foto']['tmp_name'], 'img/'.$_FILES['foto']['name']);

            // ADICIONA NO BD
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
            $usuario->__set('foto', $_FILES['foto']['name']);
            $usuario->addFoto();

            return header('location: /painel?stt_upload=ok');

            // PARA VER A IMAGEM
            // print("<img src='img/".$_FILES['foto']['name']."' />");
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
