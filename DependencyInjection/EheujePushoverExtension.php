<?php

namespace Eheuje\PushoverBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class EheujePushoverExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $pusherService = $container->getDefinition('eheuje_pushover.pusher');
        $pusherService->addMethodCall('setUserKey', [ $config['application']['user_key'] ]);
        $pusherService->addMethodCall('setApiKey', [ $config['application']['api_key'] ]);
        $pusherService->addMethodCall('setApiKey', [ $config['application']['api_key'] ]);
        if (isset($config['additional_information'])) {
            $pusherService->addMethodCall('setAdditionalInformation', [ $config['additional_information'] ]);
        }
    }
}
