<?php

	namespace Uneak\AdminBundle\Twig\Extension;

	use Symfony\Bundle\FrameworkBundle\Routing\Router;
	use Twig_Extension;
	use Uneak\AdminBundle\Route\FlattenRoute;
	use Uneak\AdminBundle\Route\FlattenRoutePool;

	class RouteExtension extends Twig_Extension {

		private $environment;
		private $route;

		public function __construct(FlattenRoute $route) {
			$this->route = $route;
		}

		public function initRuntime(\Twig_Environment $environment) {
			$this->environment = $environment;
		}

		public function getFunctions() {
			$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

			return array(
				'routePath' => new \Twig_Function_Method($this, 'routePathFunction', $options),
				'metaData' => new \Twig_Function_Method($this, 'metaDataFunction', $options),
			);
		}

		public function metaDataFunction($key, $path = null, $parameters = null) {
			return $this->route->getChild($path, $parameters)->getMetaData($key);
		}

		public function routePathFunction($path = null, $parameters = null) {
			return $this->route->getChild($path, $parameters)->getRoutePath();
		}


		public function getGlobals() {
			return \array_merge($this->route->getMetaDatas(), array(
					'route'     => $this->route,
					'routePath' => $this->route->getRoutePath(),
				)
			);
		}

		public function getName() {
			return 'admin_route';
		}

	}
