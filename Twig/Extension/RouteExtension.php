<?php

namespace Uneak\AdminBundle\Twig\Extension;

use Twig_Extension;
use Twig_Function_Method;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Uneak\AdminBundle\Route\FlattenRoutePool;
use Uneak\AdminBundle\Route\FlattenRoute;

class RouteExtension extends Twig_Extension {

	private $environment;
	private $router;
	private $routePool;

	public function __construct(Router $router, FlattenRoutePool $routePool) {
		$this->router = $router;
		$this->routePool = $routePool;
	}

	public function initRuntime(\Twig_Environment $environment) {
		$this->environment = $environment;
	}

	public function getFunctions() {
		$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

		return array(
			'routePath' => new Twig_Function_Method($this, 'routePathFunction', $options),
			'routeCrudPath' => new Twig_Function_Method($this, 'routeCrudPathFunction', $options),
			
			'routeId' => new Twig_Function_Method($this, 'routeIdFunction', $options),
			'routeCrudId' => new Twig_Function_Method($this, 'routeCrudIdFunction', $options),
			
			'routeMetaData' => new Twig_Function_Method($this, 'routeMetaDataFunction', $options),
		);
	}

	public function routeMetaDataFunction($key, $flattenRoute = null) {
		if (!$flattenRoute) {
			$flattenRoute = $this->routePool->getRoute();
		} else if (is_string ($flattenRoute)) {
			$flattenRoute = $this->routePool->findRoute($flattenRoute);
		}
		return $flattenRoute->getMetaData($key);
	}

	
	public function routeCrudIdFunction($path = null) {
		$crud = $this->routePool->getCrud();
		return $this->_findRouteId($crud, $path);
	}

	public function routeIdFunction($path = null) {
		$route = $this->routePool->getRoute();
		return $this->_findRouteId($route, $path);
	}
	
	
	public function routeCrudPathFunction($path = null, $parameters = array()) {
		$crud = $this->routePool->getCrud();
		$mergedParameters = array_merge($this->_routeParameters($crud), $parameters);
		return $this->_findRoutePath($crud, $path, $mergedParameters);
	}

	public function routePathFunction($path = null, $parameters = array()) {
		$route = $this->routePool->getRoute();
		$mergedParameters = array_merge($this->_routeParameters($route), $parameters);
		return $this->_findRoutePath($route, $path, $mergedParameters);
	}

	private function _routeParameters(FlattenRoute $flattenRoute) {
		$parameters = array();
		$params = $flattenRoute->getParameters();
		foreach ($params as $key => $param) {
			$parameters[$key] = $this->routePool->findRoute($param)->getParameterValue();
		}
		return $parameters;
	}

	private function _findRoutePath(FlattenRoute $flattenRoute, $path = null, $parameters = array()) {
		return $this->router->generate($this->_findRouteId($flattenRoute, $path), $parameters);
	}

	private function _findRouteId(FlattenRoute $flattenRoute, $path = null) {
		return ($path) ? $flattenRoute->getId() . '.' . $path : $flattenRoute->getId();
	}
	
	public function getGlobals() {
		$route = $this->routePool->getRoute();

		return \array_merge($route->getMetaDatas(), array(
			'routePool' => $this->routePool,
//            'routeIcon' => $route->getIcon(),
//            'routeLabel' => $route->getLabel(),
//            'routeDescription' => $route->getDescription(),
			'routePath' => $this->router->generate($route->getId(), $this->_routeParameters($this->routePool->getRoute())),
				)
		);
	}

	public function getName() {
		return 'admin_route';
	}

}
