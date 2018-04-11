<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Template\RendererIntegration;
use Rougin\Slytherin\Http\HttpIntegration;
use Zapheus\Container\Container;
use Zapheus\Provider\Configuration;

/**
 * Slytherin Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SlytherinProviderTest extends \PHPUnit_Framework_TestCase
{
    const CONTAINER = 'Rougin\Slytherin\Container\Container';

    const RENDERER = 'Rougin\Slytherin\Template\RendererInterface';

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
        list($config, $container) = array(new Configuration, new Container);

        $config->set('app.views', __DIR__ . '/Fixture');

        $this->container = $container->set(SlytherinProvider::CONFIG, $config);

        $providers = array(new HttpIntegration, new RendererIntegration);

        $this->provider = new SlytherinProvider($providers);
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $container = $container->get(self::CONTAINER);

        $renderer = $container->get(self::RENDERER);

        $expected = 'Hello world';

        $result = $renderer->render('HelloWorld');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ContainerInterface::has from ProviderInterface::register.
     *
     * @return void
     */
    public function testHasMethodOfContainerFromRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $container = $container->get(self::CONTAINER);

        $renderer = 'Rougin\Slytherin\Template\RendererInterface';

        $this->assertTrue($container->has($renderer));
    }
}
