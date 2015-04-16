<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedAdminRoute;
use Uneak\AdminBundle\Route\NestedGridRoute;

class NestedCRUDRoute extends NestedAdminRoute {

	public function __construct($id) {
		parent::__construct($id);
		$this->setEnabled(false);
	}

	public function getNestedType() {
		return "NestedCRUDRoute";
	}

	public function initialize() {
		$this->buildCRUD();
	}

	protected function buildCRUD() {

		$indexRoute = new NestedGridRoute('index');
		$indexRoute->setPath('list');
		$indexRoute->setAction('index');
		$this->addChild($indexRoute);

		$newRoute = new NestedAdminRoute('new');
		$newRoute->setPath('new');
		$newRoute->setAction('new');
		$newRoute->setMetaData('_icon', 'plus-circle');
		$newRoute->setMetaData('_label', 'New');
		$this->addChild($newRoute);

		$subjectRoute = new NestedEntityRoute('subject');
		$subjectRoute->setParameterName($this->getId());
		$subjectRoute->setParameterPattern('\d+');
		$subjectRoute->setEnabled(false);
		$this->addChild($subjectRoute);

		$showRoute = new NestedAdminRoute('show');
		$showRoute->setAction('show');
		$showRoute->setRequirement('_method', 'GET');
		$subjectRoute->addChild($showRoute);

		$editRoute = new NestedAdminRoute('edit');
		$editRoute->setAction('edit');
		$editRoute->setMetaData('_icon', 'edit');
		$editRoute->setMetaData('_label', 'Edit');
		$subjectRoute->addChild($editRoute);

		$deleteRoute = new NestedAdminRoute('delete');
		$deleteRoute->setAction('delete');
		$deleteRoute->setMetaData('_icon', 'times');
		$deleteRoute->setMetaData('_label', 'Delete');
		$subjectRoute->addChild($deleteRoute);
	}

}
