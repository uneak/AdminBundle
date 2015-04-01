<?php

namespace Uneak\AdminBundle\Route;

use Symfony\Component\Routing\RouteCollection;
use Uneak\AdminBundle\Route\NestedRouteManager;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Resource\FileResource;
use Uneak\AdminBundle\Route\FlattenRouteFactory;
use ReflectionObject;

class RoutesLoader extends FileLoader {

	protected $nRouteManager;
	protected $flattenRouteFactory;

	public function __construct(NestedRouteManager $nRouteManager, FlattenRouteFactory $flattenRouteFactory) {
//        parent::__construct($locator);
		$this->nRouteManager = $nRouteManager;
		$this->flattenRouteFactory = $flattenRouteFactory;
	}

	public function load($resource, $type = null) {
		$routes = new RouteCollection();
		$nRoutes = $this->nRouteManager->getNestedRoutes();

//		ld('route loader');
		foreach ($nRoutes as $nRoute) {
			$flattenRoutes = $this->flattenRouteFactory->getFlattenRoutes($nRoute);
			foreach ($flattenRoutes as $key => $route) {
				$routes->add($key, $route);
			}
			$reflection = new ReflectionObject($nRoute);
			$routes->addResource(new FileResource($reflection->getFileName()));
		}

		return $routes;
	}

	public function supports($resource, $type = null) {
		return 'admin_routes' === $type;
	}

}
