<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Container\Container as SlytherinContainer;
use Rougin\Slytherin\Integration\Configuration as SlytherinConfig;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Zapheus\Container\WritableInterface;
use Zapheus\Provider\Configuration;
use Zapheus\Provider\ProviderInterface;

/**
 * Slytherin Provider
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SlytherinProvider implements ProviderInterface
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

        $slytherin = new SlytherinContainer;

        $config = new SlytherinConfig($config->all());

        foreach ((array) $this->integrations as $item) {
            $slytherin = $item->define($slytherin, $config);
        }

        return $container->set(self::CONTAINER, $slytherin);
    }
}
