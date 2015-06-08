<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets;


	abstract class Assets {

		protected $tag;
		protected $group;
		protected $dependencies = array();

		public function __construct() {
		}

		public function getDependencies() {
			return $this->dependencies;
		}

		public function addDependency($dependency) {
			array_push($this->dependencies, $dependency);
			return $this;
		}

		public function setDependencies($dependencies) {
			$this->dependencies = $dependencies;
			return $this;
		}

		public function getTag() {
			return $this->tag;
		}

		public function setTag($tag) {
			$this->tag = $tag;
			return $this;
		}

		public function getGroup() {
			return $this->group;
		}

		public function setGroup($group) {
			$this->group = $group;
			return $this;
		}


	}