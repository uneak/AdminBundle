<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Block;

	class ScriptJs extends Script {

		protected $type;

		public function __construct($content = "", $parameters = array(), $tag = "script", $priority = 0, $group = "ScriptJs") {
			$this->tag = $tag;
			$this->priority = $priority;
			$this->parameters = $parameters;
			$this->group = $group;
			$this->type = "text/javascript";
			$this->content = $content;
		}

		public function getType() {
			return $this->type;
		}

		public function setType($type) {
			$this->type = $type;
		}

	}