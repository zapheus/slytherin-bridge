<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Routing\Router;
use Zapheus\Container\Container as ZapheusContainer;
use Rougin\Slytherin\Container\Container as SlytherinContainer;
use Zapheus\Provider\Configuration;
use Zapheus\Routing\Route;

/**
 * Routing Provider Test
 *
 * @package Zapheus
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class RoutingProviderTest extends \PHPUnit_Framework_TestCase
{
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
        list($config, $router) = array(new Configuration, new Router);

        $zapheus = new ZapheusContainer(array());

        $slytherin = new SlytherinContainer(array(), null);

        $this->container = $zapheus->set(RoutingProvider::CONFIG, $config);

        $router->get('/', 'TestController@index');

        $slytherin->set(RoutingProvider::ROUTER, $router);

        $this->container->set(BridgeProvider::CONTAINER, $slytherin);

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

        $router = $container->get(RoutingProvider::ZAPHEUS_ROUTER);

        $handler = array((string) 'TestController', 'index');

        $expected = array(new Route('GET', '/', $handler));

        $result = $router->routes();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ProviderInterface::register without existing Slytherin router.
     *
     * @return void
     */
    public function testRegisterMethodWithoutSlytherinRouter()
    {
        $container = $this->provider->register(new ZapheusContainer);

        $expected = (string) RoutingProvider::ZAPHEUS_ROUTER;

        $result = $container->get(RoutingProvider::ZAPHEUS_ROUTER);

        $this->assertInstanceOf($expected, $result);
    }
}
