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
    const CONTAINER = 'Rougin\Slytherin\Container\Container';

    /**
     * @var \Rougin\Slytherin\Integration\IntegrationInterface[]
     */
    protected $integrations;

    /**
     * Initializes the provider instance.
     *
     * @param \Rougin\Slytherin\Integration\IntegrationInterface[] $integrations
     */
    public function __construct($integrations)
    {
        $this->integrations = $integrations;
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $config = $container->get(ProviderInterface::CONFIG);

        $config = new SlytherinConfig($config->all());

        $slytherin = new Container;

        foreach ((array) $this->integrations as $item) {
            $slytherin = $item->define($slytherin, $config);
        }

        return $container->set(self::CONTAINER, $slytherin);
    }
}
