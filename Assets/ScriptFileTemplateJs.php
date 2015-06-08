<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets;

	class ScriptFileTemplateJs extends Script {

		public function __construct($content = "", $dependencies = null, $parameters = array(), $group = "ScriptJs") {
			$this->dependencies = $dependencies;
			$this->parameters = $parameters;
			$this->group = $group;
			$this->content = $content;
		}

	}