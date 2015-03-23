<?php

namespace Uneak\AdminBundle\Route;

class FlattenRoutePool {

	protected $parameters = array();
	protected $route;
	protected $router;
	protected $crud;
	private $routeCollection;

	public function __construct($router) {
		$this->router = $router;
		$this->routeCollection = $this->router->getRouteCollection();
	}

	public function setRoute(FlattenRoute $flattenRoute) {
		$this->route = $flattenRoute;
		$this->crud = $this->routeCollection->get($flattenRoute->getCRUD());
		return $this;
	}

	public function getRoute() {
		return $this->route;
	}

	public function getCrud() {
		return $this->crud;
	}


	public function findRoute($path) {
		return $this->routeCollection->get($path);
	}

	public function getRoutePath($path = null, $parameters = array()) {
		$mergedParameters = array_merge($this->_routeParameters($this->route), $parameters);
		return $this->_findRoutePath($this->route, $path, $mergedParameters);
	}

	public function getRouteId($path = null) {
		return $this->_findRouteId($this->route, $path);
	}

	public function getRouteCrudPath($path = null, $parameters = array()) {
		$mergedParameters = array_merge($this->_routeParameters($this->crud), $parameters);
		return $this->_findRoutePath($this->crud, $path, $mergedParameters);
	}

	public function getRouteCrudId($path = null) {
		return $this->_findRouteId($this->crud, $path);
	}



	public function getRouteMetaData($key, $flattenRoute = null) {
		if (!$flattenRoute) {
			$flattenRoute = $this->route;
		} else if (is_string($flattenRoute)) {
			$flattenRoute = $this->findRoute($flattenRoute);
		}
		return $flattenRoute->getMetaData($key);
	}

	public function setRouteMetaData($key, $value, $flattenRoute = null) {
		if (!$flattenRoute) {
			$flattenRoute = $this->route;
		} else if (is_string($flattenRoute)) {
			$flattenRoute = $this->findRoute($flattenRoute);
		}
		return $flattenRoute->setMetaData($key, $value);
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



	private function _routeParameters(FlattenRoute $flattenRoute) {
		$parameters = array();
		$params = $flattenRoute->getParameters();
		foreach ($params as $key => $param) {
			$parameters[$key] = $this->findRoute($param)->getParameterValue();
		}
		return $parameters;
	}

	private function _findRoutePath(FlattenRoute $flattenRoute, $path = null, $parameters = array()) {
		return $this->router->generate($this->_findRouteId($flattenRoute, $path), $parameters);
	}

	private function _findRouteId(FlattenRoute $flattenRoute, $path = null) {
		return ($path) ? $flattenRoute->getId() . '.' . $path : $flattenRoute->getId();
	}


}
