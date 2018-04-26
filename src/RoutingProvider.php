<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Routing\Router as SlytherinRouter;
use Rougin\Slytherin\Routing\RouterInterface;
use Zapheus\Container\ContainerInterface;
use Zapheus\Container\WritableInterface;
use Zapheus\Provider\ProviderInterface;
use Zapheus\Routing\Route;
use Zapheus\Routing\Router as ZapheusRouter;

/**
 * Routing Provider
 *
 * @package App
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RoutingProvider implements ProviderInterface
{
    const ROUTER = 'Rougin\Slytherin\Routing\RouterInterface';

    const ZAPHEUS_ROUTER = 'Zapheus\Routing\RouterInterface';

    /**
     * @var \Rougin\Slytherin\Routing\RouterInterface|null
     */
    protected $router;

    /**
     * Initializes the provider instance.
     *
     * @param \Rougin\Slytherin\Routing\RouterInterface|null $router
     */
    public function __construct(RouterInterface $router = null)
    {
        $this->router = $router;
    }

    /**
     * Registers the bindings in the container.
     *
     * @param  \Zapheus\Container\WritableInterface $container
     * @return \Zapheus\Container\ContainerInterface
     */
    public function register(WritableInterface $container)
    {
        $slytherin = $this->slytherin($container);

        $zapheus = $this->zapheus($container);

        foreach ((array) $slytherin->routes() as $route) {
            list($method, $uri, $handler) = (array) $route;

            $zapheus->add(new Route($method, $uri, $handler));
        }

        return $container->set(self::ZAPHEUS_ROUTER, $zapheus);
    }

    /**
     * Returns the Slytherin router if it does exists from container.
     *
     * @param  \Zapheus\Container\ContainerInterface $container
     * @return \Zapheus\Routing\RouterInterface
     */
    protected function slytherin(ContainerInterface $container)
    {
        $exists = $container->has(BridgeProvider::CONTAINER);

        $router = $this->router;

        if ($this->router === null && $exists === true) {
            $slytherin = $container->get(BridgeProvider::CONTAINER);

            return $slytherin->get((string) self::ROUTER);
        }

        return $router === null ? new SlytherinRouter : $router;
    }

    /**
     * Returns the Zapheus router if it does exists from container.
     *
     * @param  \Zapheus\Container\ContainerInterface $container
     * @return \Zapheus\Routing\RouterInterface
     */
    protected function zapheus(ContainerInterface $container)
    {
        $exists = $container->has((string) self::ZAPHEUS_ROUTER);

        $router = new ZapheusRouter;

        return $exists ? $container->get(self::ZAPHEUS_ROUTER) : $router;
    }
}
