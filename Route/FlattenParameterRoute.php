<?php

namespace Uneak\AdminBundle\Route;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Uneak\AdminBundle\Route\FlattenRoute;

class FlattenParameterRoute extends FlattenRoute {

	protected $parameterName = null;
	protected $parameterPattern = null;
	protected $parameterDefault = null;
	protected $parameterValue = null;

	public function __construct(Router $router, FlattenRouteManager $flattenRouteManager, $data = null) {
		parent::__construct($router, $flattenRouteManager, $data);
	}

	public function getParameterValue() {
		return $this->parameterValue;
	}

	public function setParameterValue($parameterValue) {
		$this->parameterValue = $parameterValue;
		return $this;
	}

	public function getParameterName() {
		return $this->parameterName;
	}

	public function getParameterPattern() {
		return $this->parameterPattern;
	}

	public function getParameterDefault() {
		return $this->parameterDefault;
	}

	public function getArray() {
		$array = parent::getArray();
		if ($this->parameterName) {
			$array['parameter_name'] = $this->parameterName;
			if ($this->parameterDefault) {
				$array['default'][$this->parameterName] = $this->parameterDefault;
			}
			if ($this->parameterPattern) {
				$array['requirements'][$this->parameterName] = $this->parameterPattern;
			}
		}
		return $array;
	}

	public function buildArray($array) {
		parent::buildArray($array);
		$this->parameterName = (isset($array['parameter_name'])) ? $array['parameter_name'] : null;
		if ($this->parameterName) {
			$this->parameterDefault = (isset($array['default'][$this->parameterName])) ? $array['default'][$this->parameterName] : null;
			$this->parameterPattern = (isset($array['requirements'][$this->parameterName])) ? $array['requirements'][$this->parameterName] : null;
		}
	}

}
