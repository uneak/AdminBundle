<?php

	namespace Uneak\AdminBundle\Helper;

	use Doctrine\ORM\Query\Expr;
	use Knp\Menu\FactoryInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\RequestStack;
	use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
	use Uneak\AdminBundle\Route\FlattenRoute;
	use Uneak\AdminBundle\Security\Authorization\Voter\RouteVoter;

	class MenuHelper {

		private $factory;
		private $authorization;
		private $requestStack;

		public function __construct(FactoryInterface $factory, AuthorizationChecker $authorization, RequestStack $requestStack) {
			$this->factory = $factory;
			$this->authorization = $authorization;
			$this->requestStack = $requestStack;
		}

		public function getFactory() {
			return $this->factory;
		}

		public function createItem(FlattenRoute $flattenRoute) {

			if ($this->authorization->isGranted(RouteVoter::ROUTE_GRANTED, $flattenRoute) === true) {

				$label = $flattenRoute->getMetaData("_label");
				$icon = $flattenRoute->getMetaData("_icon");
				$badge = $flattenRoute->getMetaData("_badge");
				$requestUri = $this->requestStack->getCurrentRequest()->getRequestUri();
				$uri = $flattenRoute->getRoutePath();

				$menu = array();
				if ($label) {
					$menu['label'] = $label;
				}
				if ($icon) {
					$menu['icon'] = $icon;
				}
				if ($badge) {
					$menu['badge'] = $badge;
				}
				if ($uri == $requestUri) {
					$menu['attributes'] = array("class" => "active");
				}

				$menu['uri'] = $uri;

				return $this->factory->createItem($flattenRoute->getId(), $menu);
			}

			return null;

		}

		public function createMenu($actions, FlattenRoute $flattenRoute, $parameters = null) {
			$root = $this->factory->createItem('root');
			foreach ($actions as $action) {
				$route = $flattenRoute->getChild($action, $parameters);
				$menuItem = $this->createItem($route);
				if ($menuItem) {
					$root->addChild($menuItem);
				}
			}
			return $root;
		}



	}
