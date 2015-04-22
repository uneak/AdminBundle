<?php

namespace Uneak\AdminBundle\Route;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Uneak\AdminBundle\Route\FlattenParameterRoute;

class FlattenEntityRoute extends FlattenParameterRoute {

    protected $entity;
    protected $parameterSubject = null;
	protected $em;

    public function __construct(Router $router, FlattenRouteManager $flattenRouteManager, EntityManager $em, $data = null) {
        parent::__construct($router, $flattenRouteManager, $data);
		$this->em = $em;
    }

    public function getEntity() {
        return $this->entity;
    }

	public function setParameterValue($parameterValue) {
		parent::setParameterValue($parameterValue);
		$this->parameterSubject = $this->getNestedRoute()->findEntity($this->em, $this->getEntity(), $parameterValue);
		return $this;
	}

    public function getParameterSubject() {
            return $this->parameterSubject;
    }

    public function getArray() {
        $array = parent::getArray();
        $array['entity'] = $this->entity;
        return $array;
    }

    public function buildArray($array) {
        parent::buildArray($array);
        $this->entity = (isset($array['entity'])) ? $array['entity'] : '';
    }
    
    
}
