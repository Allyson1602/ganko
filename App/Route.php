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
		$routes['cadastrar'] = array(
			'route' => '/cadastrar',
			'controller' => 'indexController',
			'action' => 'cadastrar'
		);
		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);
		$routes['cadastroConcluido'] = array(
			'route' => '/cadastro_concluido',
			'controller' => 'indexController',
			'action' => 'cadastro_concluido'
		);
		$routes['recuperarConta'] = array(
			'route' => '/recuperar_conta',
			'controller' => 'indexController',
			'action' => 'recuperarConta'
		);
		$routes['recuperandoConta'] = array(
			'route' => '/recuperando_conta',
			'controller' => 'indexController',
			'action' => 'recuperandoConta'
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

		$this->setRoutes($routes);
	}

}

?>