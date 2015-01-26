<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\FlattenParameterRoute;

class FlattenEntityRoute extends FlattenParameterRoute {

    protected $entity;
    protected $parameterSubject = null;
        
    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getParameterSubject() {
            return $this->parameterSubject;
    }

    public function setParameterSubject($parameterSubject) {
            $this->parameterSubject = $parameterSubject;
            return $this;
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
