<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle\Twig;

use Twig\Extension\AbstractExtension;

final class FaExtension extends AbstractExtension
{
    public function __construct(
        private readonly FaTokenParser $tokenParser,
    ) {
    }

    public function getTokenParsers(): array
    {
        return [$this->tokenParser];
    }
}
