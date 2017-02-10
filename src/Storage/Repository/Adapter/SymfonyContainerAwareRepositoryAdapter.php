<?php
namespace TijmenWierenga\Bogus\Storage\Repository\Adapter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Acclimate\Container\ContainerAcclimator;
use TijmenWierenga\Bogus\Config\Config;
use TijmenWierenga\Bogus\Storage\Repository\RepositoryStorage;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class SymfonyContainerAwareRepositoryAdapter extends RepositoryStorage
{
    /**
     * SymfonyContainerAwareRepositoryAdapter constructor.
     * @param ContainerInterface $container
     * @param Config $config
     */
    public function __construct(ContainerInterface $container, Config $config)
    {
        $acclimator = new ContainerAcclimator;
        $container = $acclimator->acclimate($container);

        parent::__construct($container, $config);
    }
}
