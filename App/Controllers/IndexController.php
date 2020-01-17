<?php
	namespace App\Controllers;

	// recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;

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
	}

?>