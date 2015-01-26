<?php

namespace Uneak\AdminBundle\Route;

class FlattenRoutePool {

	protected $parameters = array();
	protected $route;
	protected $crud;
	private $routeCollection;

	public function __construct($router) {
		$this->routeCollection = $router->getRouteCollection();
	}

	public function setRoute(FlattenRoute $flattenRoute) {
		$this->route = $flattenRoute;
		$this->crud = $this->routeCollection->get($flattenRoute->getCRUD());
		return $this;
	}

	public function findRoute($path) {
		return $this->routeCollection->get($path);
	}

	public function getRoute() {
		return $this->route;
	}

	public function getCrud() {
		return $this->crud;
	}

	public function setParameter($key, $value) {
		$this->parameters[$key] = $value;
		return $this;
	}

	public function getParameter($key) {
		return $this->parameters[$key];
	}

	public function getParameters() {
		return $this->parameters;
	}

}
