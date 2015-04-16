<?php

namespace Uneak\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Twig_Environment;
use Uneak\AdminBundle\Block\BlockManager;
use Uneak\AdminBundle\Twig\Extension\PoolExtension;
use Uneak\AdminBundle\Route\FlattenRoute;
use Uneak\AdminBundle\Route\FlattenParameterRoute;
use Uneak\AdminBundle\Route\FlattenEntityRoute;
use Uneak\AdminBundle\Route\FlattenRoutePool;
use Doctrine\ORM\EntityManager;
use Uneak\AdminBundle\Twig\Extension\RouteExtension;

class FlattenRouteControllerListener {


    private $flattenRoutePool;
    private $router;
    private $twig;
    private $em;
	private $blockManager;

    public function __construct(FlattenRoutePool $flattenRoutePool, Router $router, Twig_Environment $twig, EntityManager $em, BlockManager $blockManager) {
        $this->flattenRoutePool = $flattenRoutePool;
        $this->router = $router;
        $this->twig = $twig;
        $this->em = $em;
		$this->blockManager = $blockManager;
    }

    public function onKernelController(FilterControllerEvent $event) {

        $request = $event->getRequest();
        $routeCollection = $this->router->getRouteCollection();
        $route = $routeCollection->get($request->attributes->get('_route'));

        if ($route instanceof FlattenRoute) {
            $this->flattenRoutePool->setRoute($route);
            $routeParams = $request->attributes->get('_route_params');

            foreach ($route->getParameters() as $key => $paramRoute) {

                $paramRoute->setParameterValue($routeParams[$key]);

                if ($paramRoute instanceof FlattenEntityRoute) {
                    $nestedRoute = $paramRoute->getNestedRoute();
                    $entity = $nestedRoute->findEntity($this->em, $paramRoute->getEntity(), $routeParams[$key]);
                    $request->attributes->set($key, $entity);
                    $paramRoute->setParameterSubject($entity);
                }
                
                $this->flattenRoutePool->setParameter($key, $paramRoute);
            }


            $request->attributes->set('routePool', $this->flattenRoutePool);
			$request->attributes->set('blockManager', $this->blockManager);

//			$poolParameters = new PoolExtension('flatten_route');
//			$poolParameters->addParameter('flattenRoutePool', $this->flattenRoutePool);
//			$this->twig->addExtension($poolParameters);

            $this->twig->addExtension(new RouteExtension($this->flattenRoutePool));

        }
    }

}
