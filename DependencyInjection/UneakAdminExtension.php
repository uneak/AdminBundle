<?php

namespace Uneak\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class UneakAdminExtension extends Extension {

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) {

		$processor = new Processor();
        $configuration = new Configuration();

		$config = $processor->processConfiguration($configuration, $configs);
		$container->setParameter('uneak.admin.root_path', $config['root_path']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('asset.yml');
        $loader->load('block.yml');
        $loader->load('form.yml');
        $loader->load('routes.yml');
        $loader->load('helper.yml');
    }

}
