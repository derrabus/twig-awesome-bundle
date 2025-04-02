<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle\Twig;

use Rabus\TwigAwesomeBundle\IconLocator;
use Twig\Error\SyntaxError;
use Twig\Node\TextNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;
use Twig\TokenStream;

final class FaTokenParser extends AbstractTokenParser
{
    public function __construct(
        private readonly IconLocator $iconLocator,
    ) {
    }

    public function parse(Token $token): TextNode
    {
        $stream = $this->parser->getStream();

        $collection = $this->parseNameToken($stream);
        $faId = str_replace('_', '-', $this->parseNameToken($stream));

        $stream->expect(Token::BLOCK_END_TYPE);

        return new TextNode($this->iconLocator->getSvg($collection, $faId), $token->getLine());
    }

    public function getTag(): string
    {
        return 'fa';
    }

    /** @throws SyntaxError */
    private function parseNameToken(TokenStream $stream): string
    {
        $token = $stream->expect(Token::NAME_TYPE)->getValue();
        if (!\is_string($token)) {
            throw new \UnexpectedValueException(\sprintf('Expected a string token, got %s"', get_debug_type($token)));
        }

        return $token;
    }
}
