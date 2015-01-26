<?php

namespace Uneak\AdminBundle\Route;

class NestedRouteManager {

    protected $nRoutes;

    public function __construct() {
        $this->nRoutes = array();
    }

    public function addNestedRoute(NestedRoute $nRoute) {
        $this->nRoutes[$nRoute->getId()] = $nRoute;
    }

    public function getNestedRoutes() {
        return $this->nRoutes;
    }

    public function getNestedRoute($nRoute_id, $path = null) {
        if (is_null($path)) {
            return $this->nRoutes[$nRoute_id];
        }
        return $this->nRoutes[$nRoute_id]->getChild($path);
    }

}
