<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRoute;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\FileResource;
use Uneak\AdminBundle\Route\FlattenRouteFactory;
use ReflectionObject;

class RoutesCache {

	protected $cacheFolder;
	protected $debug;
	protected $flattenRouteFactory;

	public function __construct($cacheFolder, $debug, FlattenRouteFactory $flattenFactory) {
		$this->cacheFolder = $cacheFolder;
		$this->debug = $debug;
		$this->flattenRouteFactory = $flattenFactory;
	}

	public function load(NestedRoute $nestedRoute) {
		$filename = $this->cacheFolder . '/route_' . md5($nestedRoute->getId());

		$cache = new ConfigCache($filename, $this->debug);
		if (!$cache->isFresh()) {
			$resources = array();

			$reflection = new ReflectionObject($nestedRoute);
			$resources[] = new FileResource($reflection->getFileName());

			$cache->write(serialize($this->flattenRouteFactory->getFlattenRoutes($nestedRoute)), $resources);
		}

		return unserialize(file_get_contents($filename));
	}

}
