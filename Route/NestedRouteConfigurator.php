<?php

namespace Uneak\AdminBundle\Route;

use Uneak\AdminBundle\Route\NestedRouteManager;
use Uneak\AdminBundle\Route\NestedRoute;

class NestedRouteConfigurator {

    protected $nRouteManager = null;

    public function __construct(NestedRouteManager $nRouteManager) {
        $this->nRouteManager = $nRouteManager;
    }

    public function configure(NestedRoute $nestedRoute) {
        $path = $nestedRoute->getParentPath();
        if ($path) {
            $re = "/^(.*?)\\.(.*)$|^(.*?)$/m"; 
            preg_match($re, $path, $matches);
            
            if (isset($matches[3])) {
                $admin = $matches[3];
                $child = null;
            } else {
                $admin = $matches[1];
                $child = $matches[2];
            }

            $parentRoute = $this->nRouteManager->getNestedRoute($admin, $child);
            if ($parentRoute) {
                $nestedRoute->setParent($parentRoute);
            }
        }
        
    }

}
