<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle\Twig;

use Twig\Attribute\YieldReady;
use Twig\Compiler;
use Twig\Node\Node;
use Twig\Node\TextNode;

/** @deprecated use {@see TextNode} instead. */
#[YieldReady]
final class FaNode extends Node
{
    public function __construct(string $svg, int $lineno = 0, ?string $tag = null)
    {
        parent::__construct(
            [],
            ['svg' => $svg],
            $lineno,
            $tag
        );
    }

    public function compile(Compiler $compiler): void
    {
        $compiler->addDebugInfo($this)
            ->raw('yield ')
            ->string($this->attributes['svg'])
            ->raw(';')
        ;
    }
}
