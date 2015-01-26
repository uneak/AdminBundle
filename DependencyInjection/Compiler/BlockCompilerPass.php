<?php

namespace Uneak\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class BlockCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container) {
        if ($container->hasDefinition('uneak.admin.block.manager') === false) {
            return;
        }
        $definition = $container->getDefinition('uneak.admin.block.manager');
        $taggedServices = $container->findTaggedServiceIds('uneak.admin.block');
		
        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                        'addBlock', array($attributes['id'], new Reference($id), $attributes['priority'], $attributes['group'])
                );
            }
        }
    }

}
