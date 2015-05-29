<?php

	namespace Uneak\AdminBundle\Block;

	use Uneak\AdminBundle\Assets\AssetsDependencyInterface;

	abstract class Block implements BlockInterface, AssetsDependencyInterface {

		protected $title;
		protected $template;
		protected $metas;

		public function __construct() {
			$this->metas = new Meta($this);
		}

		public function preRender() {
		}

		public function _registerExternalFile() {
			return array();
		}

		public function _registerScript() {
			return array();
		}

		public function getExternalFiles($group = null) {

			$externalFiles = $this->_registerExternalFile();
			$array = array();
			foreach ($externalFiles as $key => $externalFile) {
				if ($group) {
					if ($externalFile->getGroup() == $group) {
						$array[$key] = $externalFile;
					}
				} else {
					$array[$key] = $externalFile;
				}
			}

			return $array;
		}


		public function getScripts($group = null) {
			$scripts = $this->_registerScript();
			$array = array();
			foreach ($scripts as $key => $script) {
				if ($group) {
					if ($script->getGroup() == $group) {
						$array[$key] = $script;
					}
				} else {
					$array[$key] = $script;
				}
			}

			return $array;
		}


		public function getMetas() {
			return $this->metas;
		}

		public function getMeta($key) {
			return $this->metas->__get($key);
		}

		public function setMeta($key, $value) {
			$this->metas->__set($key, $value);

			return $this;
		}

		public function getTemplate() {
			return $this->template;
		}

		public function setTemplate($template) {
			$this->template = $template;

			return $this;
		}

		public function getTitle() {
			return $this->title;
		}

		public function setTitle($title) {
			$this->title = $title;

			return $this;
		}


	}
