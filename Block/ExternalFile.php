<?php

	namespace Uneak\AdminBundle\Block;


	abstract class ExternalFile extends Assets {

		protected $type;
		protected $class;
		protected $src;

		public function __construct() {
		}

		public function getType() {
			return $this->type;
		}

		public function getSrc() {
			return $this->src;
		}

		public function setType($type) {
			$this->type = $type;

			return $this;
		}

		public function getClass() {
			return $this->class;
		}

		public function setClass($class) {
			$this->class = $class;

			return $this;
		}


		public function __toString() {
			return '';
		}


	}