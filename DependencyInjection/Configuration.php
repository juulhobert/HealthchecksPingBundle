<?php

namespace JH\HealthchecksPingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        if (version_compare(Kernel::VERSION, '4.2', '>=')) {
            $tb = new TreeBuilder();
            $root = $tb->getRootNode();
        } else {
            $tb = new TreeBuilder();
            $root = $tb->root('healthchecks');
        }

        $root->children()
            ->scalarNode('ping_url')
                ->isRequired()
                ->validate()
                    ->ifTrue(function($value) {
                        return !filter_var($value, FILTER_VALIDATE_URL);
                    })
                    ->thenInvalid('Ping url is not valid')
                ->end()
            ->end()
            ->booleanNode('only_cli')
                ->defaultTrue()
            ->end()
        ->end();

        return $tb;
    }
}