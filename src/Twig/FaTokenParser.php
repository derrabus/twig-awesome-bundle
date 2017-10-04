<?php

namespace Rabus\TwigAwesomeBundle\Twig;

use Rabus\TwigAwesomeBundle\IconLocator;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class FaTokenParser extends AbstractTokenParser
{
    /**
     * @var IconLocator
     */
    private $iconLocator;

    public function __construct(IconLocator $iconLocator)
    {
        $this->iconLocator = $iconLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function parse(Token $token): Node
    {
        $stream = $this->parser->getStream();

        $faId = str_replace(
            '_',
            '-',
            $stream->expect(Token::NAME_TYPE)->getValue()
        );
        $stream->expect(Token::BLOCK_END_TYPE);

        return new FaNode($this->iconLocator->getSvg($faId), $token->getLine(), $this->getTag());
    }

    /**
     * {@inheritdoc}
     */
    public function getTag(): string
    {
        return 'fa';
    }
}
