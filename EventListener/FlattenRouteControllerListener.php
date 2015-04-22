<?php

namespace Uneak\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Twig_Environment;
use Uneak\AdminBundle\Block\BlockManager;
use Uneak\AdminBundle\Security\Authorization\Voter\RouteVoter;
use Uneak\AdminBundle\Twig\Extension\PoolExtension;
use Uneak\AdminBundle\Route\FlattenRoute;
use Uneak\AdminBundle\Route\FlattenParameterRoute;
use Uneak\AdminBundle\Route\FlattenEntityRoute;
use Uneak\AdminBundle\Route\FlattenRoutePool;
use Doctrine\ORM\EntityManager;
use Uneak\AdminBundle\Twig\Extension\RouteExtension;

class FlattenRouteControllerListener {

    private $router;
    private $twig;
	private $blockManager;
	private $authorization;

    public function __construct(Router $router, Twig_Environment $twig, BlockManager $blockManager, AuthorizationChecker $authorization) {
        $this->router = $router;
        $this->twig = $twig;
		$this->blockManager = $blockManager;
		$this->authorization = $authorization;
    }

    public function onKernelController(FilterControllerEvent $event) {

        $request = $event->getRequest();
        $routeCollection = $this->router->getRouteCollection();
        $route = $routeCollection->get($request->attributes->get('_route'));

        if ($route instanceof FlattenRoute) {

            $routeParams = $request->attributes->get('_route_params');

            foreach ($route->getParameters() as $key => $paramRoute) {
                $paramRoute->setParameterValue($routeParams[$key]);
                if ($paramRoute instanceof FlattenEntityRoute) {
                    $request->attributes->set($key, $paramRoute->getParameterSubject());
                }
            }


			if ($this->authorization->isGranted(RouteVoter::ROUTE_GRANTED, $route) === false) {
				throw new AccessDeniedException('Unauthorised access!');
			}

            $request->attributes->set('route', $route);
			$request->attributes->set('blockManager', $this->blockManager);

//			$poolParameters = new PoolExtension('flatten_route');
//			$poolParameters->addParameter('flattenRoutePool', $this->flattenRoutePool);
//			$this->twig->addExtension($poolParameters);

            $this->twig->addExtension(new RouteExtension($route));

        }
    }

}
