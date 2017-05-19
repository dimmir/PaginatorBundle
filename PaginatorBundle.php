<?php

namespace DMR\Bundle\PaginatorBundle;

use DMR\Bundle\PaginatorBundle\DependencyInjection\Compiler\PaginatorFactoryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PaginatorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PaginatorFactoryPass());
    }
}
