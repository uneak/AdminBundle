<?php

namespace Uneak\AdminBundle\Route;

use Symfony\Component\Routing\Route;

abstract class AbstractRoute extends Route {

	protected $id;
	protected $parent = null;
	protected $children = array();
	protected $enabled = true;

	public function __construct() {
		parent::__construct('/');
		$this->children = array();
	}

	public function getId() {
		return $this->id;
	}

	public function isEnabled() {
		return !!$this->enabled;
	}

	public function getParent() {
		return $this->parent;
	}

	public function getChildren() {
		return $this->children;
	}

	public function getArray() {
		return array(
			'id' => $this->id,
			'path' => $this->getPath(),
			'host' => $this->getHost(),
			'defaults' => $this->getDefaults(),
			'requirements' => $this->getRequirements(),
			'options' => $this->getOptions(),
			'schemes' => $this->getSchemes(),
			'methods' => $this->getMethods(),
			'condition' => $this->getCondition(),
		);
	}

	public function buildArray($array) {
		$this->id = $array['id'];
		$this->setPath($array['path']);
		$this->setHost($array['host']);
		$this->setDefaults($array['defaults']);
		$this->setRequirements($array['requirements']);
		$this->setOptions($array['options']);
		$this->setSchemes($array['schemes']);
		$this->setMethods($array['methods']);
		$this->setCondition($array['condition']);
	}

	public function serialize() {
		return serialize($this->getArray());
	}

	public function unserialize($data) {
		$data = unserialize($data);
		$this->buildArray($data);
	}

}
