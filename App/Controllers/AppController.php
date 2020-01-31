<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class AppController extends Action{
        public function painel(){
            $this->validar();
            $this->validaKinesis();
            $this->validaFoto();
            $this->getPost();

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

            if($kinesis->validaKinesis()['primaria'] != ''){
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

            // VERIFICA SE PRIMARIA E SECUNDARIA SÃO IGUAIS
            foreach($_POST['secundaria'] as $ki_secundaria){
                if($_POST['primaria'] == $ki_secundaria){
                    return header('location: /alterar_dados?msg=kinesis_iguais');
                }
            }
            
            // FORMATO DE ARQUIVO
            $extensao = $_FILES['foto']['type'];
            if($extensao != 'image/jpg' && $extensao != 'image/png' && $extensao != 'image/jpeg' && $extensao != ''){
                return header('location: /alterar_dados?stt_upload=formato_bloqueado');
            }
            print $extensao;
            // LIMITE DE TAMANHO DO ARQUIVO
            if($_FILES['foto']['size'] > 500000){
                return header('location: /alterar_dados?stt_upload=tamanho_exedido');
            }
            // MOVE ARQUIVOS PARA A PASTA IMG
            date_default_timezone_set("Brazil/East");// DATA E HORA ACERTADAS
            if($_FILES['foto']['name'] != ''){
                $nome_foto = $_SESSION['nick'].date("dmYHis").'.'.pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            }else{ 
                $nome_foto = '';
            }
            move_uploaded_file($_FILES['foto']['tmp_name'], 'img/perfil/'.$_SESSION['nick'].date("dmYHis").'.'.pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            $usuario->__set('foto', $nome_foto);
			$usuario->__set('nascimento', $_POST['nascimento']);
			$usuario->__set('genero', $_POST['genero']);
			$usuario->__set('comeco', $_POST['comeco']);
			$usuario->__set('nick', $_POST['login']);
            $usuario->__set('email', $_POST['email']);
            $usuario->__set('id', $_SESSION['id']);

			$this->view->loginExiste = false;
			$this->view->emailExiste = false;

			if(count($usuario->nickExiste()) != 0 && $usuario->nickExiste()[0]['nick'] != $_SESSION['nick']){
                return header('location: /alterar_dados?msg=nickExiste');
			}
			if(count($usuario->emailExiste()) != 0 && $usuario->emailExiste()[0]['email'] != $_SESSION['email']){
                return header('location: /alterar_dados?msg=emailExiste');
            }
            
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

            if($usuario->validaFoto()['foto'] != ''){
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
        }
        public function setPost(){
            $this->validar();

            $post = Container::getModel('Post');

            $post->__set('id_usuario', $_SESSION['id']);
            $post->__set('texto', $_POST['post_texto']);
            $post->__set('imagem', $_POST['post_imagem']);
            $post->__set('video', $_POST['post_video']);

            $post->addPost();

            return header('location: /painel?msg=postado');
        }
        public function getPost(){
            $post = Container::getModel('Post');
            $usuario = Container::getModel('Usuario');

            $this->view->postagens = $post->getAll();
            $this->view->usuarios = $usuario->pegarTodos();

            // echo '<pre>';
            // print_r($usuario->pegarTodos());
            // echo '<pre>';

            ## mostrar os dados dos usuários ##
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
