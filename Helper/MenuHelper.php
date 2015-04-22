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

		public function createMenu($root, $actions, FlattenRoute $flattenRoute, $parameters = null) {
			foreach ($actions as $action) {
				$route = $flattenRoute->getChild($action, $parameters);
				if ($this->authorization->isGranted(RouteVoter::ROUTE_GRANTED, $route) === true) {
					$root->addChild($this->createItem($route));
				}
			}
			return $root;
		}






	}
