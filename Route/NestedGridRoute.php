<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRoute;

class NestedGridRoute extends NestedAdminRoute {

	protected $actions = array();
	protected $rowActions = array();
	protected $columns = array();
	protected $gridRoute;

	public function __construct($id) {
		parent::__construct($id);

		$this->gridRoute = new NestedRoute('_grid');
		$this->gridRoute->setPath('_grid');
		$this->gridRoute->setAction('grid');
		$this->addChild($this->gridRoute);

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

	public function addColumn($array) {
		$this->columns[] = $array;
		return $this;
	}

	public function getColumns() {
		return $this->columns;
	}

}
