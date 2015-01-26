<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\AbstractRoute;

class NestedRoute extends AbstractRoute {

    protected $parentPath = null;
    protected $controller = null;
    protected $action = null;
//    protected $label = '';
//    protected $description = '';
//    protected $icon = null;
    protected $metaDatas = array();

    public function __construct($id) {
        parent::__construct();
        $this->id = $id;
        $this->setPath($id);
    }

    public function initialize() {
        // abstract // first call after creation
    }

    public function getNestedType() {
        return "NestedRoute";
    }

    public function setEnabled($enabled) {
        $this->enabled = $enabled;
        return $this;
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function setController($controller) {
        $this->controller = $controller;
        return $this;
    }

    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

//    public function setParent(NestedRoute $parent, $path = null) {
//        if (!is_null($path)) {
//            $parent = $parent->getChild($path);
//        }
//        if ($this->parent != $parent) {
//            $this->parent = $parent;
//            $parent->addChild($this);
//        }
//        return $this;
//    }

    public function getParentPath() {
        return $this->parentPath;
    }

    public function setParentPath($path) {
        $this->parentPath = $path;
        return $this;
    }

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    public function addChild(NestedRoute $child) {
        if (array_search($child, $this->children) === false) {
            $this->children[$child->getId()] = $child;
            $child->setParent($this);
        }
    }

    public function getChild($path) {
        $paths = explode(".", $path);
        $path = array_shift($paths);
        if (count($paths) > 0) {
            return $this->children[$path]->getChild(implode(".", $paths));
        } else {
            return $this->children[$path];
        }
    }

    public function getChildren() {
        return $this->children;
    }
//
//    function getLabel() {
//        return $this->label;
//    }
//
//    function getDescription() {
//        return $this->description;
//    }
//
//    function setLabel($label) {
//        $this->label = $label;
//        return $this;
//    }
//
//    function setDescription($description) {
//        $this->description = $description;
//        return $this;
//    }
//
//    function getIcon() {
//        return $this->icon;
//    }
//
//    function setIcon($icon) {
//        $this->icon = $icon;
//        return $this;
//    }

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

}
