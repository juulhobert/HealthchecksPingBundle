<?php

namespace JH\HealthchecksPingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HealthchecksPingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('healthchecks.ping_url', $config['ping_url']);
        $container->setParameter('healthchecks.only_cli', $config['only_cli']);

        $loader = new YamlFileLoader($container, new FileLocator([
            __DIR__ . '/../Resources/config/'
        ]));
        $loader->load('services.yml');
    }
}