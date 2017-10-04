<?php

namespace Rabus\TwigAwesomeBundle\Twig;

use Twig\Compiler;
use Twig\Node\Node;

class FaNode extends Node
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

    /**
     * {@inheritdoc}
     */
    public function compile(Compiler $compiler)
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startElement('svg');
        $writer->writeAttribute('viewBox', '0 -256 1536 1792');
        $writer->writeAttribute('style', 'vertical-align: bottom;');
        $writer->startElement('path');
        $writer->writeAttribute('transform', 'translate(0, 1280), scale(1,-1)');
        $writer->writeAttribute('d', $this->attributes['svg']);
        $writer->endElement();
        $writer->endElement();

        $compiler->addDebugInfo($this)
            ->raw('echo ')
            ->string($writer->outputMemory(true))
            ->raw(';');
    }
}
