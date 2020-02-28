<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);
		$routes['inscrever'] = array(
			'route' => '/inscrever',
			'controller' => 'indexController',
			'action' => 'inscrever'
		);
		$routes['cadastrar'] = array(
			'route' => '/cadastrar',
			'controller' => 'indexController',
			'action' => 'cadastrar'
		);
		$routes['cadastrado'] = array(
			'route' => '/cadastrado',
			'controller' => 'indexController',
			'action' => 'cadastrado'
		);
		$routes['recuperar'] = array(
			'route' => '/recuperar',
			'controller' => 'indexController',
			'action' => 'recuperar'
		);
		$routes['recuperacao'] = array(
			'route' => '/recuperacao',
			'controller' => 'indexController',
			'action' => 'recuperacao'
		);
		$routes['recuperarEmail'] = array(
			'route' => '/recuperar_email',
			'controller' => 'indexController',
			'action' => 'recuperarEmail'
		);
		$routes['recuperadaConta'] = array(
			'route' => '/recuperada_conta',
			'controller' => 'indexController',
			'action' => 'recuperadaConta'
		);
		$routes['msgRecuperar'] = array(
			'route' => '/msg_recuperar',
			'controller' => 'indexController',
			'action' => 'msgRecuperar'
		);
		$routes['recuperarEmail'] = array(
			'route' => '/recuperar_email',
			'controller' => 'indexController',
			'action' => 'recuperarEmail'
		);
		$routes['editarSenha'] = array(
			'route' => '/editar_senha',
			'controller' => 'indexController',
			'action' => 'editarSenha'
		);
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);
		$routes['painel'] = array(
			'route' => '/painel',
			'controller' => 'AppController',
			'action' => 'painel'
		);
		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AppController',
			'action' => 'sair'
		);
		$routes['addKinesis'] = array(
			'route' => '/addKinesis',
			'controller' => 'AppController',
			'action' => 'addKinesis'
		);
		$routes['perfil'] = array(
			'route' => '/perfil',
			'controller' => 'AppController',
			'action' => 'perfil'
		);
		$routes['alterarDados'] = array(
			'route' => '/alterar_dados',
			'controller' => 'AppController',
			'action' => 'alterarDados'
		);
		$routes['editarDados'] = array(
			'route' => '/editar_dados',
			'controller' => 'AppController',
			'action' => 'editarDados'
		);
		$routes['deletarConta'] = array(
			'route' => '/deletar_conta',
			'controller' => 'AppController',
			'action' => 'deletarConta'
		);
		$routes['addImagem'] = array(
			'route' => '/add_imagem',
			'controller' => 'AppController',
			'action' => 'addImagem'
		);
		$routes['setPost'] = array(
			'route' => '/set_post',
			'controller' => 'AppController',
			'action' => 'setPost'
		);
		$routes['getPost'] = array(
			'route' => '/get_post',
			'controller' => 'AppController',
			'action' => 'getPost'
		);
		$routes['adicionarAmigos'] = array(
			'route' => '/adicionar_amigos',
			'controller' => 'AppController',
			'action' => 'adicionarAmigos'
		);
		$routes['procurarAmigo'] = array(
			'route' => '/procurar_amigo',
			'controller' => 'AppController',
			'action' => 'procurarAmigo'
		);
		$routes['altAmigo'] = array(
			'route' => '/alt_amigo',
			'controller' => 'AppController',
			'action' => 'altAmigo'
		);
		
		$this->setRoutes($routes);
	}

}

?>