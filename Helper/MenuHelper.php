<?php

	namespace Uneak\AdminBundle\Helper;

	use Doctrine\ORM\Query\Expr;
	use Knp\Menu\FactoryInterface;
	use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
	use Uneak\AdminBundle\Route\FlattenRoute;
	use Uneak\AdminBundle\Security\Authorization\Voter\RouteVoter;

	class MenuHelper {

		protected $factory;
		private $authorization;

		public function __construct(FactoryInterface $factory, AuthorizationChecker $authorization) {
			$this->factory = $factory;
			$this->authorization = $authorization;
		}

		public function getFactory() {
			return $this->factory;
		}

		public function createItem(FlattenRoute $flattenRoute) {

			if ($this->authorization->isGranted(RouteVoter::ROUTE_GRANTED, $flattenRoute) === true) {

				$label = $flattenRoute->getMetaData("_label");
				$icon = $flattenRoute->getMetaData("_icon");
				$badge = $flattenRoute->getMetaData("_badge");

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
				$menu['uri'] = $flattenRoute->getRoutePath();

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
