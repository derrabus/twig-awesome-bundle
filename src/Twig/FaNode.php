<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle\Twig;

use Twig\Compiler;
use Twig\Node\Node;

final class FaNode extends Node
{
    public function __construct(string $svg, int $lineno = 0, string $tag = null)
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
            ->raw('echo ')
            ->string($this->attributes['svg'])
            ->raw(';')
        ;
    }
}
