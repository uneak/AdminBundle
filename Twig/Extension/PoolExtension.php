<?php

namespace Uneak\AdminBundle\Twig\Extension;

use Twig_Extension;


class PoolExtension extends Twig_Extension {

	private $environment;
	private $poolArray = array();
	private $extensionName;

	public function __construct($extensionName) {
		$this->extensionName = $extensionName;
	}
	public function initRuntime(\Twig_Environment $environment) {
		$this->environment = $environment;
	}

	public function addParameter($key, $value) {
		$this->poolArray[$key] = $value;
	}

	public function getGlobals() {
		return $this->poolArray;
	}

	public function getName() {
		return 'admin_pool_'.$this->extensionName;
	}

}
