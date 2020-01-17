<?php
	namespace App\Controllers;

	// recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;
	
	// PHPMAILER
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;


	class IndexController extends Action{
		public function index() {
			$this->render("index");
		}
		public function cadastrar(){
			$this->view->usuario = array(
				'nome' => '',
				'sobrenome' => '',
				'nascimento' => '',
				'genero' => '',
				'comeco' => '',
				'nick' => '',
				'email' => ''
			);
			
			$this->view->loginExiste = false;
			$this->view->emailExiste = false;

			$this->render("cadastrar");
		}
		public function registrar(){
			$usuario = Container::getModel('Usuario');

			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('sobrenome', $_POST['sobrenome']);
			$usuario->__set('nascimento', $_POST['nascimento']);
			$usuario->__set('genero', $_POST['genero']);
			$usuario->__set('comeco', $_POST['comeco']);
			$usuario->__set('senha', md5($_POST['senha']));
			$usuario->__set('nick', $_POST['login']);
			$usuario->__set('email', $_POST['email']);

			$this->view->loginExiste = false;
			$this->view->emailExiste = false;

			if(count($usuario->nickExiste()) != 0){
				$this->view->loginExiste = false;

				$this->view->usuario = array(
					'nome' => $_POST['nome'],
					'sobrenome' => $_POST['sobrenome'],
					'nascimento' => $_POST['nascimento'],
					'genero' => $_POST['genero'],
					'comeco' => $_POST['comeco'],
					'nick' => $_POST['login'],
					'email' => $_POST['email']
				);

				$this->view->loginExiste = true;

				$this->render('/cadastrar');
			}
			if(count($usuario->emailExiste()) != 0){
				$this->view->emailExiste = false;

				$this->view->usuario = array(
					'nome' => $_POST['nome'],
					'sobrenome' => $_POST['sobrenome'],
					'nascimento' => $_POST['nascimento'],
					'genero' => $_POST['genero'],
					'comeco' => $_POST['comeco'],
					'nick' => $_POST['login'],
					'email' => $_POST['email']
				);

				$this->view->emailExiste = true;

				$this->render('/cadastrar');
			}else{
				$usuario->inserir();

				$this->render('/cadastro_concluido');
			}
		}
		public function cadastroConcluido(){
			$this->render('/cadastro_concluido');
		}
		public function recuperarConta(){
			$this->render('/recuperar_conta');
		}
		public function recuperandoConta(){			
			$usuario = Container::getModel('Usuario');

			$usuario->__set('email', $_GET['email']);
			$emailCadastrado = $usuario->recuperarContaBD();

			if($emailCadastrado != 0){
					// ###################COLOCAR NA WEB PARA FUNCIONAR, AINDA NÃO TESTADO###################

					// chave
					$chave = md5(rand());

					// chave no bd
					$usuario->__set('chave_recuperacao', $chave);
					$usuario->enviarChave();

					// envio de email
					// $de = "facilitaUDF@gmail.com";
					// $titulo = "Recuperação de conta na Bambu";
					// $msg = "<h3>Olá ".$emailCadastrado['nome']."</h3> <br/><br/> <p>Foi requisitada a alteração da senha na sua conta Bambu,<br/> confirme a alteração neste link <a href='"./recuperar_email?chave=$chave."'>RECUPERAR CONTA</a><br/> caso não tenha sido você o solicitante, por favor desconsidere este email.</p><p>Não responda esse email</p>";

					// // use wordwrap() if lines are longer than 70 characters
					// $msg = wordwrap($msg,70);

					// $headers = "From: ".$_GET['email']."\r\n"."CC: ".$_GET['email'];

					// mail($de,$titulo,$msg,$headers);

					$this->render('recuperada_conta');
			}
		}
		public function recuperarEmail(){
			// passar email para db usuarios
			$usuario = Container::getModel('Usuario');

			$chavelink = $_GET['chave'];
			$chaveemail = $usuario->validaEmail();
			$chaveemail = $chaveemail['chave_recuperacao'];
			if($chaveemail === $chavelink){
				// redireciona para atualizar dados
			}

			$this->render('/recuperar_email');
		}
	}

?>