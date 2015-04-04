<?php

namespace Albumgrab\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class CrawlerExtension implements ExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'albumgrab';
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespace()
    {
        return 'http://archfizz.org/schema/dic/'.$this->getAlias();
    }
}
