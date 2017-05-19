<?php

namespace DMR\Bundle\PaginatorBundle\DependencyInjection\Compiler;

use DMR\Bundle\PaginatorBundle\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class PaginatorFactoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $providerService = $container->getDefinition('dmr_paginator.service');

        if (!$providerService) {
            return;
        }

        $factories = [];
        foreach ($container->findTaggedServiceIds('dmr_paginator.paginator_factory') as $serviceId => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['class_name'])) {
                    throw new RuntimeException('Factory tags must have an "class_name" property.');
                }

                $factories[$tag['class_name']] = new Reference($serviceId);
            }
        }

        if (empty($factories)) {
            return;
        }

        $providerService->replaceArgument(0, $factories);
    }
}