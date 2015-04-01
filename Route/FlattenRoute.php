<?php

	namespace Uneak\AdminBundle\Route;

	class FlattenRoute extends AbstractRoute {

		protected $slug;
		protected $nestedRoute;
		protected $enabled;
		protected $metaDatas;
		protected $crud;
		protected $parameters = array();

		public function __construct($data = null) {
			parent::__construct();
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
			return $this->metaDatas[$key];
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

		public function getChild($path) {
			$paths = explode(".", $path);
			$path = array_shift($paths);
			if (count($paths) > 0) {
				return $this->children[$path]->getChild(implode(".", $paths));
			} else {
				return $this->children[$path];
			}
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

		public function getArray() {
			$array = parent::getArray();
			$array['nested_route'] = $this->nestedRoute;
			$array['enabled'] = $this->enabled;
//			$array['children'] = $this->children;
			$array['parent'] = $this->parent;
			$array['slug'] = $this->slug;
			$array['meta_datas'] = $this->metaDatas;
			$array['crud'] = $this->crud;
			$array['parameters'] = $this->parameters;

			return $array;
		}

	}
