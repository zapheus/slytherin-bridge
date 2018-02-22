<?php

namespace Zapheus\Bridge\Slytherin;

use Rougin\Slytherin\Template\RendererIntegration;
use Rougin\Slytherin\Http\HttpIntegration;
use Zapheus\Container\Container;
use Zapheus\Provider\Configuration;
use Zapheus\Provider\FrameworkProvider;

/**
 * Provider Test
 *
 * @package Zapheus
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ProviderTest extends \PHPUnit_Framework_TestCase
{
    const RENDERER = 'Rougin\Slytherin\Template\RendererInterface';

    /**
     * @var \Zapheus\Container\WritableInterface
     */
    protected $container;

    /**
     * @var \Zapheus\Provider\FrameworkProvider
     */
    protected $framework;

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
        $message = 'Slytherin Renderer is not yet installed.';

        $renderer = 'Rougin\Slytherin\Template\TwigRenderer';

        class_exists($renderer) || $this->markTestSkipped($message);

        list($config, $container) = array(new Configuration, new Container);

        $config->set('app.views', __DIR__ . '/Fixture');

        $this->container = $container->set(Provider::CONFIG, $config);

        $this->framework = new FrameworkProvider;

        $providers = array(new HttpIntegration, new RendererIntegration);

        $this->provider = new Provider($providers);
    }

    /**
     * Tests ProviderInterface::register.
     *
     * @return void
     */
    public function testRegisterMethod()
    {
        $container = $this->provider->register($this->container);

        $container = $this->framework->register($container);

        $renderer = $container->get(self::RENDERER);

        $expected = 'Hello world';

        $result = $renderer->render('helloworld');

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

        $container = $this->framework->register($container);

        $renderer = 'Rougin\Slytherin\Template\RendererInterface';

        $this->assertTrue($container->has($renderer));
    }
}
