<?php

namespace Uneak\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Uneak\AdminBundle\Route\FlattenRoute;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Uneak\AdminBundle\Block\BlockManager;
use Twig_Environment;


class BlockControllerListener {

	private $router;
	private $blockManager;
	private $twig;

	public function __construct(BlockManager $blockManager, Router $router, Twig_Environment $twig) {
		$this->blockManager = $blockManager;
		$this->router = $router;
		$this->twig = $twig;
	}

	public function onKernelController(FilterControllerEvent $event) {
		$request = $event->getRequest();
		$routeCollection = $this->router->getRouteCollection();
		$route = $routeCollection->get($request->attributes->get('_route'));

		if ($route instanceof FlattenRoute) {
			$request->attributes->set('blockManager', $this->blockManager);
		}
	}



}
