<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration as SlytherinConfig;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Zapheus\Container\WritableInterface;
use Zapheus\Provider\Configuration;
use Zapheus\Provider\ProviderInterface;

/**
 * Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Provider implements ProviderInterface
{
    /**
     * @var \Rougin\Slytherin\Integration\IntegrationInterface
     */
    protected $integration;

    /**
     * Initializes the provider instance.
     *
     * @param \Rougin\Slytherin\Integration\IntegrationInterface $integration
     */
    public function __construct(IntegrationInterface $integration)
    {
        $this->integration = $integration;
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $name = 'Rougin\Slytherin\Container\Container';

        $slytherin = new Container;

        $container->has($name) && $slytherin = $container->get($name);

        $integration = $this->integration;

        $config = $container->get(ProviderInterface::CONFIG);

        $config = new SlytherinConfig($config->all());

        $result = $integration->define($slytherin, $config);

        return $container->set($name, $result);
    }
}
