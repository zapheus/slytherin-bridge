<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Http\HttpIntegration;
use Rougin\Slytherin\Routing\Router;
use Rougin\Slytherin\Template\RendererIntegration;
use Zapheus\Container\Container as ZapheusContainer;
use Rougin\Slytherin\Container\Container as SlytherinContainer;
use Zapheus\Provider\Configuration;
use Zapheus\Routing\Route;

/**
 * Routing Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RoutingProviderTest extends \PHPUnit_Framework_TestCase
{
    const SLYTHERIN_CONTAINER = 'Rougin\Slytherin\Container\Container';

    const SLYTHERIN_ROUTER = 'Rougin\Slytherin\Routing\RouterInterface';

    const ZAPHEUS_ROUTER = 'Zapheus\Routing\RouterInterface';

    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Provider\ProviderInterface
     */
    protected $provider;

    /**
     * Sets up the provider instance.
     *
     * @return void
     */
    public function setUp()
    {
        $zapheus = new ZapheusContainer;

        $config = new Configuration;

        $slytherin = new SlytherinContainer;

        $this->container = $zapheus->set(RoutingProvider::CONFIG, $config);

        $router = new Router;

        $router->get('/', 'TestController@index');

        $slytherin->set(self::SLYTHERIN_ROUTER, $router);

        $this->container->set(self::SLYTHERIN_CONTAINER, $slytherin);

        $this->provider = new RoutingProvider;
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $router = $container->get(self::ZAPHEUS_ROUTER);

        $handler = array((string) 'TestController', 'index');

        $expected = array(new Route('GET', '/', $handler));

        $result = $router->routes();

        $this->assertEquals($expected, $result);
    }
}