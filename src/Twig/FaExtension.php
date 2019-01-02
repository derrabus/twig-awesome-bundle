<?php

namespace Rabus\TwigAwesomeBundle\Twig;

use Twig\Extension\AbstractExtension;

final class FaExtension extends AbstractExtension
{
    private $tokenParser;

    public function __construct(FaTokenParser $tokenParser)
    {
        $this->tokenParser = $tokenParser;
    }

    public function getTokenParsers(): array
    {
        return [$this->tokenParser];
    }
}
