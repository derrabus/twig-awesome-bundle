<?php

namespace Rabus\TwigAwesomeBundle\Twig;

use Twig\Extension\AbstractExtension;

class FaExtension extends AbstractExtension
{
    /**
     * @var FaTokenParser
     */
    private $tokenParser;

    public function __construct(FaTokenParser $tokenParser)
    {
        $this->tokenParser = $tokenParser;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers(): array
    {
        return [$this->tokenParser];
    }
}
