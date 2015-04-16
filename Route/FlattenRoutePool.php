<?php

namespace Uneak\AdminBundle\Route;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FlattenRoutePool {

	protected $parameters = array();
	protected $route;
	protected $router;
	protected $crud;
	protected $fRouteManager;
	private $routeCollection;

	public function __construct(FlattenRouteManager $fRouteManager, UrlGeneratorInterface $router) {
		$this->fRouteManager = $fRouteManager;
		$this->router = $router;
		$this->routeCollection = $this->router->getRouteCollection();
	}

	public function setRoute(FlattenRoute $flattenRoute) {
		$this->route = $flattenRoute;
		$this->crud = $flattenRoute->getCRUD();
		return $this;
	}

	public function getRoutes() {
		return $this->fRouteManager->getFlattenRoutes();
	}

	public function getRouteAbsolute($path = null, $parameters = array()) {
		return $this->fRouteManager->getFlattenRoute($path, $parameters);
	}

	public function getRoute($path = null) {
		return ($path) ? $this->route->getChild($path) : $this->route;
	}

	public function getCrud($path = null) {
		return ($path) ? $this->crud->getChild($path) : $this->crud;
	}

	public function findRoute($path) {
		return $this->routeCollection->get($path);
	}

	public function findRouteId(FlattenRoute $flattenRoute, $path = null) {
		$target = ($path) ? $flattenRoute->getChild($path) : $flattenRoute;
		return $target->getId();
	}

	public function findRoutePath(FlattenRoute $flattenRoute, $path = null, $parameters = array()) {
		$routeParameters = array();
		foreach ($flattenRoute->getParameters() as $key => $flattenRouteParameter) {
			$routeParameters[$key] = $flattenRouteParameter->getParameterValue();
		}

		$mergedParameters = array_merge($routeParameters, $parameters);
		return $this->router->generate($this->findRouteId($flattenRoute, $path), $mergedParameters);
	}

	public function getRoutePath($path = null, $parameters = array()) {
		return $this->findRoutePath($this->route, $path, $parameters);
	}






	public function getRouteId($path = null) {
		return $this->findRouteId($this->route, $path);
	}

	public function getRouteCrudPath($path = null, $parameters = array()) {
		$mergedParameters = array_merge($this->_routeParameters($this->crud), $parameters);
		return $this->findRoutePath($this->crud, $path, $mergedParameters);
	}

	public function getRouteAbsolutePath($path, $parameters = array()) {
		return $this->findRoutePath($this->fRouteManager->getFlattenRoute($path), null, $parameters);
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
			$parameters[$key] = $param->getParameterValue();
		}
		return $parameters;
	}






}
