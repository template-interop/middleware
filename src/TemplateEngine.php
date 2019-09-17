<?php

namespace Interop\Template\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Interop\Template\TemplateEngineInterface;

final class TemplateEngine implements MiddlewareInterface
{
    /** @var TemplateEngineInterface */
    private $engine;

    /** @var StreamFactoryInterface */
    private $streamFactory;

    /** @var string */
    private $templateNameAttribute,  $templateParametersAttribute;

    public function __construct(
        TemplateEngineInterface $engine,
        StreamFactoryInterface $streamFactory,
        string $templateNameAttribute = 'template-name',
        string $templateParametersAttribute = 'template-parameters'
    ) {
        $this->engine                       = $engine;
        $this->streamFactory                = $streamFactory;
        $this->templateNameAttribute        = $templateNameAttribute;
        $this->templateParametersAttribute  = $templateParametersAttribute;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        if ($request->getAttribute($this->templateNameAttribute)) {
            $response = $response->withBody(
                $this->streamFactory->createStream(
                    $this->engine->render(
                        $request->getAttribute($this->templateNameAttribute),
                        $request->getAttribute($this->templateParametersAttribute)
                    )
                )
            );
        }

        return $response;
    }
}
