<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets;

	class ScriptJs extends Script {

		protected $type;

		public function __construct($content = "", $dependencies = null, $parameters = array(), $tag = "script", $group = "ScriptJs") {
			$this->dependencies = $dependencies;
			$this->tag = $tag;
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