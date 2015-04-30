<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Block;

	class Script extends Assets {


		protected $content;
		protected $parameters;

		public function __construct() {
		}

		public function getContent() {
			return $this->content;
		}

		public function setContent($content) {
			$this->content = $content;
			return $this;
		}


		public function getParameters() {
			return $this->parameters;
		}


		public function addParameter($key, $value) {
			$this->parameters[$key] = $value;
			return $this;
		}

		public function removeParameter($key) {
			unset($this->parameters[$key]);
			return $this;
		}


		public function setParameters($array) {
			$this->parameters = $array;
			return $this;
		}

	}