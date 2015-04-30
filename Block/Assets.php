<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Block;


	abstract class Assets {

		protected $tag;
		protected $priority = 0;
		protected $group;

		public function __construct() {
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

		public function getPriority() {
			return $this->priority;
		}

		public function setPriority($priority) {
			$this->priority = $priority;

			return $this;
		}


	}