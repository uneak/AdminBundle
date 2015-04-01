<?php

	namespace Uneak\AdminBundle\Twig\Extension;

	use Symfony\Bundle\FrameworkBundle\Routing\Router;
	use Twig_Extension;
	use Uneak\AdminBundle\Route\FlattenRoute;
	use Uneak\AdminBundle\Route\FlattenRoutePool;

	class RouteExtension extends Twig_Extension {

		private $environment;
		private $routePool;

		public function __construct(FlattenRoutePool $routePool) {
			$this->routePool = $routePool;
		}

		public function initRuntime(\Twig_Environment $environment) {
			$this->environment = $environment;
		}

		public function getFunctions() {
			$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

			return array(
				'routePath'     => new \Twig_Function_Method($this, 'routePathFunction', $options),
				'routeCrudPath' => new \Twig_Function_Method($this, 'routeCrudPathFunction', $options),

				'routeId'       => new \Twig_Function_Method($this, 'routeIdFunction', $options),
				'routeCrudId'   => new \Twig_Function_Method($this, 'routeCrudIdFunction', $options),

				'routeMetaData' => new \Twig_Function_Method($this, 'routeMetaDataFunction', $options),
			);
		}

		public function routeMetaDataFunction($key, $flattenRoute = null) {
			return $this->routePool->getRouteMetaData($key, $flattenRoute);
		}

		public function routeCrudIdFunction($path = null) {
			return $this->routePool->getRouteCrudId($path);
		}

		public function routeCrudPathFunction($path = null, $parameters = array()) {
			return $this->routePool->getRouteCrudPath($path, $parameters);
		}

		public function routeIdFunction($path = null) {
			return $this->routePool->getRouteId($path);
		}

		public function routePathFunction($path = null, $parameters = array()) {
			return $this->routePool->getRoutePath($path, $parameters);
		}


		public function getGlobals() {
			$route = $this->routePool->getRoute();

			return \array_merge($route->getMetaDatas(), array(
					'route'     => $route,
					'routePool' => $this->routePool,
					'routePath' => $this->routePool->getRoutePath(),
				)
			);
		}

		public function getName() {
			return 'admin_route';
		}

	}
