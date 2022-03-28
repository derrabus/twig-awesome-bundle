<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle\Twig;

use Rabus\TwigAwesomeBundle\IconLocator;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

final class FaTokenParser extends AbstractTokenParser
{
    public function __construct(
        private readonly IconLocator $iconLocator,
    ) {
    }

    public function parse(Token $token): Node
    {
        $stream = $this->parser->getStream();

        $collection = $stream
            ->expect(Token::NAME_TYPE)
            ->getValue()
        ;

        $faId = str_replace(
            '_',
            '-',
            $stream->expect(Token::NAME_TYPE)->getValue()
        );
        $stream->expect(Token::BLOCK_END_TYPE);

        return new FaNode($this->iconLocator->getSvg($collection, $faId), $token->getLine(), $this->getTag());
    }

    public function getTag(): string
    {
        return 'fa';
    }
}
