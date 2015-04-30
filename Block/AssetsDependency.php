<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 30/01/15
	 * Time: 08:54
	 */

	namespace Uneak\AdminBundle\Block;


	class AssetsDependency {
		protected $externalFiles;
		protected $scripts;

		public function __construct() {
			$this->externalFiles = array();
			$this->scripts = array();
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
				if ($group && $externalFile->getGroup() == $group) {
					array_push($array, $externalFile);
				} else {
					array_push($array, $externalFile);
				}
			}

			usort($array, array($this, "cmpByPriority"));

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

		public function getScripts() {
			$array = array();
			foreach ($this->scripts as $scripts) {
				if ($group && $scripts->getGroup() == $group) {
					array_push($array, $scripts);
				} else {
					array_push($array, $scripts);
				}
			}

			usort($array, array($this, "cmpByPriority"));

			return $array;
		}

		public function setScripts($scripts) {
			$this->scripts = $scripts;

			return $this;
		}

		private function cmpByPriority($a, $b) {
			if ($a->getPriority() == $b->getPriority()) {
				return 0;
			}

			return ($a->getPriority() < $b->getPriority()) ? -1 : 1;
		}
	}