<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Routing\Router;
use Rougin\Slytherin\Routing\RouterInterface;
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
    const SLYTHERIN_CONTAINER = 'Rougin\Slytherin\Container\Container';

    const SLYTHERIN_ROUTER = 'Rougin\Slytherin\Routing\RouterInterface';

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
        $zapheus = new ZapheusRouter;

        $router = $this->router;

        if ($this->router === null) {
            $slytherin = $container->get(self::SLYTHERIN_CONTAINER);

            $router = $slytherin->get(self::SLYTHERIN_ROUTER);
        }

        foreach ((array) $router->routes() as $route) {
            list($method, $uri, $handler) = (array) $route;

            $zapheus->add(new Route($method, $uri, $handler));
        }

        return $container->set(self::ZAPHEUS_ROUTER, $zapheus);
    }
}
