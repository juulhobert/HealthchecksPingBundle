<?php

namespace JH\HealthchecksPingBundle\Tests;

use JH\HealthchecksPingBundle\DependencyInjection\HealthchecksPingExtension;
use JH\HealthchecksPingBundle\HealthchecksPingBundle;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HealthchecksPingExtensionTest extends TestCase
{
    /**
     * @var HealthchecksPingExtension
     */
    private $extension;

    public function testLoad()
    {
        $validConfig = [
            'healthchecks' => [
                'ping_url' => 'http://localhost',
                'only_cli' => true
            ]
        ];

        $container = new ContainerBuilder();
        $this->extension->load($validConfig, $container);

        $this->assertEquals('http://localhost', $container->getParameter('healthchecks.ping_url'));
        $this->assertEquals(true, $container->getParameter('healthchecks.only_cli'));
    }

    protected function setUp()
    {
        $bundle = new HealthchecksPingBundle();
        $this->extension = $bundle->getContainerExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', true);
        $container->setParameter('kernel.cache_dir', sys_get_temp_dir() . '/healthchecks');
        $container->setParameter('kernel.bundles', []);
        $container->registerExtension($this->extension);
    }
}