<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRouteManager;
use Uneak\AdminBundle\Route\RoutesCache;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class RoutesCacheWarmUp implements CacheWarmerInterface {

    protected $cache;
    protected $nRouteManager;

    public function __construct(RoutesCache $cache, NestedRouteManager $nRouteManager) {
        $this->cache = $cache;
        $this->nRouteManager = $nRouteManager;
    }

    public function isOptional() {
        true;
    }

    public function warmUp($cacheDir) {
        $nRoutes = $this->nRouteManager->getNestedRoutes();
        foreach ($nRoutes as $nRoute) {
            $this->cache->load($nRoute);
        }
    }

}
