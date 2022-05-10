<?php
declare (strict_types=1);

namespace App\Error\Renderer;

use Throwable;
use Slim\Exception\{
    HttpNotFoundException,
};

class HtmlErrorRenderer extends BaseHtmlErrorRenderer
{
    /**
     * @param Throwable $exception
     * @param bool      $displayErrorDetails
     * @return string
     */
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        if($exception instanceof HttpNotFoundException)
        {
            return $this->getTwig()->fetch("pages/404.twig");
        }

        return parent::__invoke($exception,$displayErrorDetails);
    }
}