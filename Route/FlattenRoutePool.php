<?php

namespace Uneak\AdminBundle\Route;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FlattenRoutePool {

	protected $parameters = array();
	protected $route;
	protected $router;
	protected $crud;
	private $routeCollection;

	public function __construct(UrlGeneratorInterface $router) {
		$this->router = $router;
		$this->routeCollection = $this->router->getRouteCollection();
	}

	public function setRoute(FlattenRoute $flattenRoute) {
		$this->route = $flattenRoute;
		$this->crud = $this->routeCollection->get($flattenRoute->getCRUD());
		return $this;
	}

	public function getRoute($path = null) {
		return ($path) ? $this->routeCollection->get($this->route->getId() . '.' . $path) : $this->route;
	}

	public function getCrud($path = null) {
		return ($path) ? $this->routeCollection->get($this->crud->getId() . '.' . $path) : $this->crud;
	}


	public function findRoute($path) {
		return $this->routeCollection->get($path);
	}

	public function findRouteId(FlattenRoute $flattenRoute, $path = null) {
		return ($path) ? $flattenRoute->getId() . '.' . $path : $flattenRoute->getId();
	}

	public function findRoutePath(FlattenRoute $flattenRoute, $path = null, $parameters = array()) {
		return $this->router->generate($this->findRouteId($flattenRoute, $path), $parameters);
	}

	public function getRoutePath($path = null, $parameters = array()) {
		$mergedParameters = array_merge($this->_routeParameters($this->route), $parameters);
		return $this->findRoutePath($this->route, $path, $mergedParameters);
	}






	public function getRouteId($path = null) {
		return $this->findRouteId($this->route, $path);
	}

	public function getRouteCrudPath($path = null, $parameters = array()) {
		$mergedParameters = array_merge($this->_routeParameters($this->crud), $parameters);
		return $this->findRoutePath($this->crud, $path, $mergedParameters);
	}

	public function getRouteCrudId($path = null) {
		return $this->findRouteId($this->crud, $path);
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






}
