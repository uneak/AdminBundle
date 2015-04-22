<?php

namespace Uneak\AdminBundle\Route;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FlattenRoutePool {

	protected $route;
	protected $fRouteManager;

	public function __construct(FlattenRouteManager $fRouteManager) {
		$this->fRouteManager = $fRouteManager;
	}


	public function setRoute(FlattenRoute $flattenRoute) {
		$this->route = $flattenRoute;
		return $this;
	}


	public function getRoutes() {
		return $this->fRouteManager->getFlattenRoutes();
	}


	public function getRoute($path = null, $parameters = null) {
		return $this->route->getChild($path, $parameters);
	}


	public function getRoutePath($path = null, $parameters = null) {
		return $this->route->getChild($path, $parameters)->getRoutePath();
	}


}
