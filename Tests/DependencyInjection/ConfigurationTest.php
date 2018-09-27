<?php

namespace JH\HealthchecksPingBundle\Tests;

use JH\HealthchecksPingBundle\DependencyInjection\Configuration;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Processor
     */
    private $processor;

    public function testValidConfiguration()
    {
        $config = $this->processor->processConfiguration(
            $this->configuration,
            [
                [
                    'ping_url' => 'http://localhost',
                    'only_cli' => true,
                ],
            ]
        );

        $this->assertArrayHasKey('ping_url', $config);
        $this->assertArrayHasKey('only_cli', $config);
        $this->assertEquals('http://localhost', $config['ping_url']);
        $this->assertEquals(true, $config['only_cli']);
    }

    /**
     * @dataProvider invalidConfigurations
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidConfigurations($invalidConfiguration)
    {
        $this->processor->processConfiguration(
            $this->configuration,
            [
                [
                    'ping_url' => 'localhost',
                    'only_cli' => true,
                ],
            ]
        );
    }

    public function invalidConfigurations()
    {
        $invalidUrl = [
            [
                'ping_url' => 'localhost',
                'only_cli' => true,
            ],
        ];
        $invalidOnlyCli = [
            [
                'ping_url' => 'http://localhost',
                'only_cli' => 1,
            ],
        ];

        return [$invalidUrl, $invalidOnlyCli];
    }

    protected function setUp()
    {
        parent::setUp();
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }
}