<?php

	namespace Uneak\AdminBundle\Block;

	abstract class Block implements BlockInterface, AssetsDependencyInterface {

		protected $title;
		protected $template;
		protected $metas;
		protected $externalFiles = array();
		protected $scripts = array();

		public function __construct() {
			$this->metas = new Meta($this);
			$this->_registerExternalFile();
			$this->_registerScript();
		}

		protected function _registerExternalFile() {

		}

		protected function _registerScript() {

		}

		public function addExternalFile(ExternalFile $externalFile) {
			array_push($this->externalFiles, $externalFile);

			return $this;
		}

		public function removeExternalFile(ExternalFile $externalFile) {
			$key = array_search($externalFile, $this->externalFiles);
			if ($key !== false) {
				array_splice($this->externalFiles, $key, 1);
			}

			return $this;
		}

		public function getExternalFiles($group = null) {
			$array = array();
			foreach ($this->externalFiles as $externalFile) {
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

		public function setExternalFiles($externalFiles) {
			$this->externalFiles = $externalFiles;

			return $this;
		}

		public function addScript(Script $scripts) {
			array_push($this->scripts, $scripts);

			return $this;
		}

		public function removeScript(Script $scripts) {
			$key = array_search($scripts, $this->scripts);
			if ($key !== false) {
				array_splice($this->scripts, $key, 1);
			}

			return $this;
		}

		public function getScripts($group = null) {
			$array = array();
			foreach ($this->scripts as $scripts) {
				if ($group) {
					if ($scripts->getGroup() == $group) {
						array_push($array, $scripts);
					}
				} else {
					array_push($array, $scripts);
				}
			}


			return $array;
		}

		public function setScripts($scripts) {
			$this->scripts = $scripts;

			return $this;
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
