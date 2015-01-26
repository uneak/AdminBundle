<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRoute;

class NestedGridRoute extends NestedRoute {

	protected $actions = array();
	protected $rowActions = array();
	protected $cols = array();

	public function __construct($id) {
		parent::__construct($id);
	}

	public function getGridRoute() {
		return $this->gridRoute;
	}
	
	public function addGridAction($key, $path) {
		$this->actions[$key] = $path;
		return $this;
	}

	public function getGridAction($key) {
		return $this->actions[$key];
	}

	public function getGridActions() {
		return $this->actions;
	}

	public function addRowAction($key, $path) {
		$this->rowActions[$key] = $path;
		return $this;
	}

	public function getRowAction($key) {
		return $this->rowActions[$key];
	}

	public function getRowActions() {
		return $this->rowActions;
	}

	public function addCol($array) {
		$this->cols[] = $array;
		return $this;
	}

	public function getCols() {
		return $this->cols;
	}

}
