<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Block;

	class ScriptFileJs extends Script {

		public function __construct($content = "", $parameters = array(), $priority = 0, $group = "ScriptJs") {
			$this->priority = $priority;
			$this->parameters = $parameters;
			$this->group = $group;
			$this->content = $content;
		}



	}