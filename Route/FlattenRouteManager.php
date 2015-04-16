<?php

	namespace Uneak\AdminBundle\Route;

	use Doctrine\ORM\EntityManager;

	class FlattenRouteManager {

		protected $fRoutes;
		protected $em;

		public function __construct(EntityManager $em) {
			$this->fRoutes = array();
			$this->em = $em;
		}

		public function addFlattenRoute(FlattenRoute $fRoute) {
			$this->fRoutes[$fRoute->getSlug()] = $fRoute;
		}

		public function getFlattenRoutes() {
			return $this->fRoutes;
		}

		public function getFlattenRoute($path, $parameters = array()) {

			$paths = explode(".", $path);
			$fRoute_id = array_shift($paths);
			if (count($paths) > 0) {
				$path = implode(".", $paths);
			} else {
				$path = null;
			}

			$flattenRoute = ($path) ? $this->fRoutes[$fRoute_id]->getChild($path) : $this->fRoutes[$fRoute_id];

			foreach ($flattenRoute->getParameters() as $key => $flattenParamRoute) {
				if (isset($parameters[$key])) {
					$flattenParamRoute->setParameterValue($parameters[$key]);
					if ($flattenParamRoute instanceof FlattenEntityRoute) {
						$entity = $flattenParamRoute->getNestedRoute()->findEntity($this->em, $flattenParamRoute->getEntity(), $parameters[$key]);
						$flattenParamRoute->setParameterSubject($entity);
					}
				}
			}

			return $flattenRoute;
		}






	}
