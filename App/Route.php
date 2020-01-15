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
		$routes['cadastrado'] = array(
			'route' => '/cadastrado',
			'controller' => 'indexController',
			'action' => 'cadastrado'
		);

		$this->setRoutes($routes);
	}

}

?>