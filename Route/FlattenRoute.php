<?php

	namespace Uneak\AdminBundle\Route;

	use Symfony\Bundle\FrameworkBundle\Routing\Router;

	class FlattenRoute extends AbstractRoute {

		protected $slug;
		protected $nestedRoute;
		protected $enabled;
		protected $metaDatas;
		protected $crud;
		protected $router;
		protected $flattenRouteManager;
		protected $parameters = array();

		public function __construct(Router $router, FlattenRouteManager $flattenRouteManager, $data = null) {
			parent::__construct();
			$this->router = $router;
			$this->flattenRouteManager = $flattenRouteManager;
			if ($data) {
				$this->buildArray($data);
			}
		}

		public function buildArray($array) {
			parent::buildArray($array);
			$this->nestedRoute = (isset($array['nested_route'])) ? $array['nested_route'] : null;
			$this->enabled = (isset($array['enabled'])) ? $array['enabled'] : '';
//			$this->children = (isset($array['children'])) ? $array['children'] : array();
			$this->parameters = (isset($array['parameters'])) ? $array['parameters'] : array();
			$this->parent = (isset($array['parent'])) ? $array['parent'] : '';
			$this->slug = (isset($array['slug'])) ? $array['slug'] : '';
			$this->metaDatas = (isset($array['meta_datas'])) ? $array['meta_datas'] : array();
			$this->crud = (isset($array['crud'])) ? $array['crud'] : '';
		}

		function getMetaDatas() {
			return $this->metaDatas;
		}

		function setMetaDatas($metaDatas) {
			$this->metaDatas = $metaDatas;

			return $this;
		}

		function getMetaData($key) {
			return (isset($this->metaDatas[$key])) ? $this->metaDatas[$key] : null;
		}

		function setMetaData($key, $value) {
			$this->metaDatas[$key] = $value;

			return $this;
		}

		function getParameters() {
			return $this->parameters;
		}

		function getParameter($id) {
			return $this->parameters[$id];
		}

		function setParameter($id, FlattenRoute $flattenRoute) {
			$this->parameters[$id] = $flattenRoute;
			return $this;
		}

		function getChildren() {
			return $this->children;
		}

		public function isEnabled() {
			return $this->enabled;
		}

		public function getNestedRoute() {
			return $this->nestedRoute;
		}

		public function addChild(FlattenRoute $child) {
			$this->children[$child->getSlug()] = $child;
			$child->setParent($this);
		}

		public function getChild($path = "", $parameters = null) {

			if ($parameters && count($parameters)) {
				$parameters = $this->updateRouteParameters($parameters);
			}

			if ($path == "") {
				return $this;

			} elseif (preg_match("/^\\/(.*)?$/", $path, $matches)) {

				// ABSOLUTE : "/hello/world"
				return $this->flattenRouteManager->getFlattenRoute($matches[1], $parameters);

			} elseif (preg_match("/^\\.\\.\\/(.*)?$/", $path, $matches)) {

				// PARENT : "../hello/world"
				return $this->getParent()->getChild($matches[1], $parameters);

			} elseif (preg_match("/^\\*\\/(.*)?$/", $path, $matches)) {

				// CRUD : "*/hello/world"
				return $this->getCRUD()->getChild($matches[1], $parameters);

			} elseif (preg_match("/([^\\/]*)(?:\\/(.*))?$/", $path, $matches)) {

				// RELATIVE : "hello/world"
				if (isset($matches[2])) {
					return $this->children[$matches[1]]->getChild($matches[2], $parameters);
				} else {
					return $this->children[$matches[1]];
				}
			} else {
				// TODO: exeption error path non reconnu
			}

			return null;
		}

		function getSlug() {
			return $this->slug;
		}

		public function setParent(FlattenRoute $parent) {
			$this->parent = $parent;
			return $this;
		}

		public function getCRUD() {
			return $this->crud;
		}

		public function setCRUD($flattenRoute) {
			$this->crud = $flattenRoute;
			return $this;
		}

		public function getArray() {
			$array = parent::getArray();
			$array['nested_route'] = $this->nestedRoute;
			$array['enabled'] = $this->enabled;
			$array['parent'] = $this->parent;
			$array['slug'] = $this->slug;
			$array['meta_datas'] = $this->metaDatas;
			$array['crud'] = $this->crud;
			$array['parameters'] = $this->parameters;

			return $array;
		}


		public function getRoutePath() {
			$parameters = array();
			foreach ($this->getParameters() as $key => $flattenParamRoute) {
				$parameters[$key] = $flattenParamRoute->getParameterValue();
			}
			return $this->router->generate($this->getId(), $parameters);
		}

		public function updateRouteParameters($parameters) {
			if ($parameters && count($parameters)) {
				foreach ($this->getParameters() as $key => $flattenParamRoute) {
					if (isset($parameters[$key])) {
						$flattenParamRoute->setParameterValue($parameters[$key]);
						unset($parameters[$key]);
					}
				}
			}
			return $parameters;
		}

		public function isGranted($attribute, $user = null) {
			return call_user_func_array($this->nestedRoute->getGrantFunction(), array($attribute, $this, $user));
		}


	}
