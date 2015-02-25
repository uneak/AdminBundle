<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Block;

	class ExternalJs extends ExternalFile {

		protected $src;

		public function __construct($src, $class = "", $type = "text/javascript", $tag = "script", $priority = 0, $group = "ExternalJs") {
			$this->priority = $priority;
			$this->group = $group;
			$this->tag = $tag;
			$this->type = $type;
			$this->src = $src;
			$this->class = $class;
		}

		public function setSrc($src) {
			$this->src = $src;
			return $this;
		}

		public function __toString() {
			$render = array();
			array_push($render, '<'.$this->getTag());
			array_push($render, ($this->getSrc()) ? 'src="'.$this->getSrc().'"' : '');
			array_push($render, ($this->getType()) ? 'type="'.$this->getType().'"' : '');
			array_push($render, ($this->getClass()) ? 'class="'.$this->getClass().'"' : '');
			array_push($render, '></'.$this->getTag().'>');

			return implode(' ', $render);

		}


	}