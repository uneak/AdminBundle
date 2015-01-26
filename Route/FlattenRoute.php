<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\AbstractRoute;

class FlattenRoute extends AbstractRoute {

    protected $slug;
    protected $nestedRoute;
    protected $enabled;
    protected $metaDatas;
//    protected $icon;
//    protected $label;
//    protected $description;
    protected $crud;
    protected $parameters = array();

    public function __construct($data = null) {
        parent::__construct();
        if ($data) {
            $this->buildArray($data);
        }
    }

    function getMetaDatas() {
        return $this->metaDatas;
    }

    function setMetaDatas($metaDatas) {
        $this->metaDatas = $metaDatas;
        return $this;
    }

    function getMetaData($key) {
        return $this->metaDatas[$key];
    }

    function setMetaData($key, $value) {
        $this->metaDatas[$key] = $value;
        return $this;
    }

//    function setIcon($icon) {
//        $this->icon = $icon;
//        return $this;
//    }
//
//    function getIcon() {
//        return $this->icon;
//    }
//
//    function setLabel($label) {
//        $this->label = $label;
//        return $this;
//    }
//
//    function getLabel() {
//        return $this->label;
//    }
//
//    function setDescription($description) {
//        $this->description = $description;
//        return $this;
//    }
//
//    function getDescription() {
//        return $this->description;
//    }

    function getParameters() {
        return $this->parameters;
    }

    function getParameter($id) {
        return $this->parameters[$id];
    }

    function getChildren() {
            return $this->children;
    }

    function getSlug() {
        return $this->slug;
    }

    public function isEnabled() {
        return $this->enabled;
    }

    public function getNestedRoute() {
        return $this->nestedRoute;
    }

    public function setParent(FlattenRoute $parent) {
        $this->parent = $parent;
        return $this;
    }

    public function addChild(FlattenRoute $child) {
        $this->children[$child->getSlug()] = $child;
        $child->setParent($this);
    }

    public function getCRUD() {
        return $this->crud;
    }

    public function getArray() {
        $array = parent::getArray();
        $array['nested_route'] = $this->nestedRoute;
        $array['enabled'] = $this->enabled;
        $array['children'] = $this->children;
        $array['parent'] = $this->parent;
        $array['slug'] = $this->slug;
        $array['meta_datas'] = $this->metaDatas;
//        $array['icon'] = $this->icon;
//        $array['label'] = $this->label;
//        $array['description'] = $this->description;
        $array['crud'] = $this->crud;
        $array['parameters'] = $this->parameters;
        return $array;
    }

    public function buildArray($array) {
        parent::buildArray($array);
        $this->nestedRoute = (isset($array['nested_route'])) ? $array['nested_route'] : null;
        $this->enabled = (isset($array['enabled'])) ? $array['enabled'] : '';
        $this->children = (isset($array['children'])) ? $array['children'] : array();
        $this->parameters = (isset($array['parameters'])) ? $array['parameters'] : array();
        $this->parent = (isset($array['parent'])) ? $array['parent'] : '';
        $this->slug = (isset($array['slug'])) ? $array['slug'] : '';
        $this->metaDatas = (isset($array['meta_datas'])) ? $array['meta_datas'] : array();
//        $this->icon = (isset($array['icon'])) ? $array['icon'] : '';
//        $this->label = (isset($array['label'])) ? $array['label'] : null;
//        $this->description = (isset($array['description'])) ? $array['description'] : null;
        $this->crud = (isset($array['crud'])) ? $array['crud'] : '';
    }

}
