<?php
declare (strict_types=1);

namespace App\Error\Renderer;

use Intoy\HebatApp\Renderer\HtmlErrorRenderer as HebatHtmlErrorRenderer;
use Psr\Container\ContainerInterface as Container;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class BaseHtmlErrorRenderer extends HebatHtmlErrorRenderer
{
    /**
     * Container
     * @var Container
     */
    protected $container;

    public function __construct(Container $c)
    {        
        $this->container=$c;
    }

    protected function getTwig():Twig
    {
        return $this->container->get(Twig::class);
    }

    protected function view(Response $response,string $template, array $data = [])
    {
        return $response->getBody()->write($this->getTwig()->fetch($template,$data));
    }
}