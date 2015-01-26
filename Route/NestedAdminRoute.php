<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRoute;

class NestedAdminRoute extends NestedRoute {

	protected $entity = null;


	public function __construct($id) {
		parent::__construct($id);
	}

	public function getNestedType() {
		return "NestedAdminRoute";
	}

	public function getEntity() {
		return $this->entity;
	}

	public function setEntity($entity) {
		$this->entity = $entity;
		return $this;
	}


}
