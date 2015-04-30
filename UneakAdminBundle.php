<?php

namespace Uneak\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Uneak\AdminBundle\DependencyInjection\Compiler\NestedRouteCompilerPass;
use Uneak\AdminBundle\DependencyInjection\Compiler\BlockCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UneakAdminBundle extends Bundle {

	public function build(ContainerBuilder $container) {
		parent::build($container);
		$container->addCompilerPass(new NestedRouteCompilerPass());
		$container->addCompilerPass(new BlockCompilerPass());
	}

}
