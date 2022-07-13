<?php

declare(strict_types=1);

namespace Umanit\TraceUserActions\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class UmanitTraceUserActionsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['MonologBundle'])) {
            throw new \LogicException('MonologBundle is required to use this bundle.');
        }

        $container->prependExtensionConfig('monolog', [
            'channels' => ['umanit_trace_user_actions'],
            'handlers' => [
                'umanit_trace_user_actions' => [
                    'type'     => 'rotating_file',
                    'level'    => 'info',
                    'path'     => '%kernel.logs_dir%/umanit-trace-user-actions-%kernel.environment%.log',
                    'channels' => 'umanit_trace_user_actions',
                ],
            ],
        ]);
    }
}
