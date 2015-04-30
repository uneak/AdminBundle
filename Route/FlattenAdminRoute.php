<?php

namespace Uneak\AdminBundle\Route;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Uneak\AdminBundle\Route\FlattenRoute;

class FlattenAdminRoute extends FlattenRoute {

    protected $admin;
    protected $entity;

    public function __construct(Router $router, FlattenRouteManager $flattenRouteManager, $data = null) {
        parent::__construct($router, $flattenRouteManager, $data);
    }



    public function getAdmin() {
        return $this->admin;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getArray() {
        $array = parent::getArray();
        $array['admin'] = $this->admin;
        $array['entity'] = $this->entity;
        return $array;
    }

    public function buildArray($array) {
        parent::buildArray($array);
        $this->admin = (isset($array['admin'])) ? $array['admin'] : null;
        $this->entity = (isset($array['entity'])) ? $array['entity'] : null;
    }

}
