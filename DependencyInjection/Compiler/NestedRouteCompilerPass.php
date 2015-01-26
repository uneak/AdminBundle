<?php

namespace Uneak\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class NestedRouteCompilerPass implements CompilerPassInterface {

	public function process(ContainerBuilder $container) {
		if ($container->hasDefinition('uneak.admin.route.nested.manager') === false) {
			return;
		}
		$nRouteManagerDef = $container->getDefinition('uneak.admin.route.nested.manager');
		$routeServices = $container->findTaggedServiceIds('uneak.route');

		foreach ($routeServices as $id => $tagAttributes) {
			$adminDef = $container->getDefinition($id);
			$adminDef->setConfigurator(array(
				new Reference('uneak.admin.route.nested.config'),
				'configure'
			));

			$adminDef->addMethodCall('initialize');
			$nRouteManagerDef->addMethodCall(
					'addNestedRoute', array(new Reference($id))
			);
		}


		//
		//	KNP MENU
		//
		
//		$knp_menu_factory_definition = $container->getDefinition('knp_menu.factory');
//		$knp_menu_factory_definition->setClass('Uneak\AdminBundle\KnpMenu\MenuFactory');
	}

}
