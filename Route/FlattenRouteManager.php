<?php

	namespace Uneak\AdminBundle\Route;

	use Doctrine\ORM\EntityManager;

	class FlattenRouteManager {

		protected $fRoutes;

		public function __construct() {
			$this->fRoutes = array();
		}

		public function addFlattenRoute(FlattenRoute $fRoute) {
			$this->fRoutes[$fRoute->getSlug()] = $fRoute;
		}

		public function getFlattenRoutes() {
			return $this->fRoutes;
		}

		public function getFlattenRoute($path, $parameters = null) {

			if (preg_match("/([^\\/]*)(?:\\/(.*))?$/", $path, $matches)) {
				if (isset($matches[2])) {
					$flattenRoute = $this->fRoutes[$matches[1]]->getChild($matches[2], $parameters);
				} else {
					$flattenRoute = $this->fRoutes[$matches[1]];
					$flattenRoute->updateRouteParameters($parameters);
				}
			} else {
				// TODO:exeption path not found
			}

			return $flattenRoute;
		}


	}
