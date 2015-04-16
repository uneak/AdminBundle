<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRoute;

class NestedParameterRoute extends NestedRoute {

	protected $parameterName;
	protected $parameterPattern;
	protected $parameterDefault;
	protected $subActions = array();

	public function __construct($id, $parameterName = null, $parameterDefault = null, $parameterPattern = null) {
		parent::__construct($id);
		$this->parameterName = ($parameterName) ? $parameterName : $id;
		$this->parameterPattern = $parameterDefault;
		$this->parameterDefault = $parameterPattern;
	}

	public function getNestedType() {
		return "NestedParameterRoute";
	}

	public function getParameterName() {
		return $this->parameterName;
	}

	public function setParameterName($parameterName) {
		$this->parameterName = $parameterName;
		return $this;
	}

	public function getParameterPattern() {
		return $this->parameterPattern;
	}

	public function getParameterDefault() {
		return $this->parameterDefault;
	}

	public function setParameterPattern($parameterPattern) {
		$this->parameterPattern = $parameterPattern;
		return $this;
	}

	public function setParameterDefault($parameterDefault) {
		$this->parameterDefault = $parameterDefault;
		return $this;
	}



	public function addSubAction($key, $path) {
		$this->subActions[$key] = $path;
		return $this;
	}

	public function getSubAction($key) {
		return $this->subActions[$key];
	}

	public function getSubActions() {
		return $this->subActions;
	}

}
