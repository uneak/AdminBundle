<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\AbstractRoute;

class NestedRoute extends AbstractRoute {

    protected $parentPath = null;
    protected $controller = null;
    protected $action = null;
    protected $metaDatas = array();
    protected $grantFunction;

    public function __construct($id) {
        parent::__construct();
        $this->id = $id;
        $this->setPath($id);
        $this->grantFunction = array($this, "isGranted");
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

	public function getChild($path = "") {

		if ($path == "") return $this;

		if (preg_match("/^\\.\\.\\/(.*)?$/", $path, $matches)) {
			return $this->getParent()->getChild($matches[1]);
		}

		if (preg_match("/([^\\/]*)(?:\\/(.*))?$/", $path, $matches)) {
			if (isset($matches[2])) {
				return $this->children[$matches[1]]->getChild($matches[2]);
			} else {
				return $this->children[$matches[1]];
			}
		}

	}


    public function getChildren() {
        return $this->children;
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

	function setGrantFunction($callable) {
		$this->grantFunction = $callable;
	}

	function getGrantFunction() {
		return $this->grantFunction;
	}


	public function isGranted($attribute, $flattenRoute, $user = null) {
		return true;
	}

}
