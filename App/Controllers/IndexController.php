<?php
// CHECKBOX DO CADASTRAR.PHTML SÓ ESTÁ PASSANDO UM VALOR
	namespace App\Controllers;

	// recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;

	class IndexController extends Action{
		public function index() {
			$this->render("index");
		}
		public function cadastrar(){
			$this->render("cadastrar");
		}
		public function cadastrado(){
			$usuario = Container::getModel('Usuario');

			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('sobrenome', $_POST['sobrenome']);
			$usuario->__set('nascimento', $_POST['nascimento']);
			$usuario->__set('primaria', $_POST['primaria']);
			$usuario->__set('secundaria', $_POST['secundaria']);
			$usuario->__set('genero', $_POST['genero']);
			$usuario->__set('comeco', $_POST['comeco']);
			$usuario->__set('senha', $_POST['senha']);
			$usuario->__set('login', $_POST['login']);
			$usuario->__set('email', $_POST['email']);

			$usuario->inserir();
		}
	}

?>