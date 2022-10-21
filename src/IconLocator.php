<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle;

use Rabus\TwigAwesomeBundle\Exception\InvalidArgumentException;
use Rabus\TwigAwesomeBundle\Exception\RuntimeException;

use const DIRECTORY_SEPARATOR;

final class IconLocator
{
    public function __construct(
        private readonly string $fontAwesomePath,
    ) {
    }

    public function getSvg(string $collection, string $id): string
    {
        $fileName = implode(DIRECTORY_SEPARATOR, [
            $this->fontAwesomePath,
             'svgs',
            $collection,
            $id.'.svg',
        ]);

        if (!file_exists($fileName)) {
            throw new InvalidArgumentException(sprintf('Could not find the requested glyph: %s of collection %s.', $id, $collection));
        }

        return file_get_contents($fileName)
            ?: throw new RuntimeException(sprintf('Could not read the requested glyph: %s of collection %s.', $id, $collection));
    }
}
