<?php
	namespace App\Controllers;

	// recursos do miniframework
	use MF\Controller\Action;
	use MF\Model\Container;

	class IndexController extends Action{
		public function index() {
			$this->render("index");
		}

		// CADASTRO
		public function inscrever(){
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

			$this->render("/inscrever");
		}
		public function cadastrar(){
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

				$this->render('/inscrever');
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

				$this->render('/inscrever');
			}else{
				$usuario->inserir();

				$this->render('/cadastrado');
			}
		}
		public function cadastrado(){
			$this->render('/cadastrado');
		}
		// CADASTRO

		// RECUPERAÇÃO DE CONTA
		// FASE 1
		public function recuperar(){
			$this->render('/recuperar');
		}
		// mover para o authcontroller
		public function recuperacao(){			
			$usuario = Container::getModel('Usuario');

			$usuario->__set('email', $_GET['email']);
			$emailCadastrado = $usuario->recuperarConta();

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
					// $msg = "<h3>Olá ".$emailCadastrado['nome']."</h3> <br/><br/> <p>Foi requisitada a alteração da senha na sua conta Bambu,<br/> confirme a alteração neste link <a href='"./recuperar_email?chave=$chave."'>RECUPERAR CONTA</a></br/><p>LINK DIRETO</p><br/> caso não tenha sido você o solicitante, por favor desconsidere este email.</p><p>Não responda esse email</p>";

					// // use wordwrap() if lines are longer than 70 characters
					// $msg = wordwrap($msg,70);

					// $headers = "From: ".$_GET['email']."\r\n"."CC: ".$_GET['email'];

					// mail($de,$titulo,$msg,$headers);
			}
			$this->render('/msg_recuperar');
		}
		public function msgRecuperar(){
			$this->render('/msg_recuperar');
		}
		// FASE 2
		public function recuperarEmail(){
			// passar email para db usuarios
			$usuario = Container::getModel('Usuario');

			$usuario->__set('chave_recuperacao', $_GET['chave']);
			$id_usuario = $usuario->validaEmail();

			if($id_usuario != ''){
				?>

					<form method="POST" action="/editar_senha">
						<div class="box_senha">
							<label>Nova senha:</label>
							<input type="password" name="nv_senha" />
						</div>
						<div class="box_confimacao">
							<label>Digite novamente:</label>
							<input type="password" name="confimacao" />
						</div>
						<div class="box_hidden">
							<input type="hidden" name="id" value="<?= $id_usuario['id']; ?>" />
						</div>
						<div class="box_submit">
							<button type="submit">alterar senha</button>
						</div>
					</form>

				<?php
			}else{
				echo 'não foi possível alterar sua senha.';
			}
		}
		public function editarSenha(){
			if($_POST['verificador'] == "true"){
				$usuario = Container::getModel('Usuario');
	
				$usuario->__set('senha', $_POST['nv_senha']);
				$usuario->alterarSenha();
			}
				
			return $this->render('/');
		}
		// RECUPERAÇÃO DE CONTA
	}

?>