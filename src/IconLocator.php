<?php

namespace Rabus\TwigAwesomeBundle;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Rabus\TwigAwesomeBundle\Exception\InvalidArgumentException;
use Traversable;
use XMLReader;

final class IconLocator implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var string
     */
    private $fontAwesomePath;

    /**
     * @var array
     */
    private $iconCache;

    public function __construct(string $fontAwesomePath)
    {
        $this->fontAwesomePath = $fontAwesomePath;
        $this->setLogger(new NullLogger());
    }

    public function getSvg(string $id): string
    {
        $this->compileCache();

        if (!isset($this->iconCache[$id])) {
            throw new InvalidArgumentException('Could not find the requested glyph.');
        }

        return $this->iconCache[$id];
    }

    private function compileCache(): void
    {
        if (null !== $this->iconCache) {
            return;
        }

        $svgByUnicode = iterator_to_array($this->parseWebfont());

        $this->iconCache = [];
        foreach ($this->parseLessVariables() as $id => $char) {
            if (!isset($svgByUnicode[$char])) {
                $this->logger->warning('Unmatched icon: '.$id);
                continue;
            }
            $this->iconCache[$id] = $svgByUnicode[$char];
        }
    }

    private function parseWebfont(): Traversable
    {
        $reader = new XMLReader();
        $reader->open($this->fontAwesomePath.'/fonts/fontawesome-webfont.svg');

        while ($reader->read()) {
            if ('glyph' !== $reader->name || XMLReader::ELEMENT !== $reader->nodeType) {
                continue;
            }

            yield $reader->getAttribute('unicode') => $reader->getAttribute('d');
        }

        $reader->close();
    }

    private function parseLessVariables(): Traversable
    {
        $file = fopen($this->fontAwesomePath.'/less/variables.less', 'r');

        while ($line = fgets($file)) {
            if (1 !== preg_match('/^@fa-var-([^:]+):\s+\"\\\\([^\"]+)\";$/', trim($line), $matches)) {
                continue;
            }

            yield $matches[1] => mb_convert_encoding(hex2bin($matches[2]), 'UTF-8', 'UCS-2');
        }
    }
}
