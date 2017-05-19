<?php

namespace DMR\Bundle\PaginatorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PaginatorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $this->remapParameters($config, $container, [
            'items_per_page' => 'dmr_paginator.default_items_per_page',
            'max_items_per_page' => 'dmr_paginator.max_items_per_page',
            'page_request_parameter_name' => 'dmr_paginator.page_request_parameter_name',
            'items_per_page_request_parameter_name' => 'dmr_paginator.items_per_page_request_parameter_name',
            'client_items_per_page' => 'dmr_paginator.client_items_per_page',
            'options' => 'dmr_paginator.options',
        ]);
    }

    /**
     * Remap application configuration into service container
     *
     * @param array $config Application configuration
     * @param ContainerBuilder $container Service container builder
     * @param array $map Mapping information
     *
     * @return void
     */
    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
                continue;
            }

            if (false !== ($pos = strpos($name, '.'))) {
                $paramKey = substr($name, 0, $pos);
                if (!isset($config[$paramKey])) {
                    continue;
                }

                $this->remapParameters($config[$paramKey], $container, array(
                    substr($name, $pos + 1) => $paramName,
                ));
            }
        }
    }
}
