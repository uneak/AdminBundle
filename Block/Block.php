<?php

	namespace Uneak\AdminBundle\Block;

	abstract class Block implements BlockInterface, AssetsDependencyInterface {

		protected $title;
		protected $template;
		protected $metas;
		protected $externalFiles = array();

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
			foreach ($externalFiles as $externalFile) {
				if ($group) {
					if ($externalFile->getGroup() == $group) {
						$array[$externalFile->getSrc()] = $externalFile;
					}
				} else {
					$array[$externalFile->getSrc()] = $externalFile;
				}
			}

			return $array;
		}


		public function getScripts($group = null) {

			$scripts = $this->_registerScript();
			$array = array();
			foreach ($scripts as $script) {
				if ($group) {
					if ($script->getGroup() == $group) {
						array_push($array, $script);
					}
				} else {
					array_push($array, $script);
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
