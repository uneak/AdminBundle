<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedParameterRoute;
use Doctrine\ORM\EntityManager;

class NestedEntityRoute extends NestedParameterRoute {

	protected $entity = null;

	public function __construct($id, $entity = null, $parameterName = null, $parameterDefault = null, $parameterPattern = null) {
		parent::__construct($id, $parameterName, $parameterDefault, $parameterPattern);
		$this->entity = $entity;
	}

	public function getNestedType() {
		return "NestedEntityRoute";
	}

	public function findEntity(EntityManager $em, $entityClass, $parameter) {
		$entityRepository = $em->getRepository($entityClass);
		return $entityRepository->find($parameter);
	}

	public function getEntity() {
		return $this->entity;
	}

	public function setEntity($entity) {
		$this->entity = $entity;
		return $this;
	}

}
