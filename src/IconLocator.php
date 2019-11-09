<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle;

use Rabus\TwigAwesomeBundle\Exception\InvalidArgumentException;
use const DIRECTORY_SEPARATOR;

final class IconLocator
{
    private $fontAwesomePath;

    public function __construct(string $fontAwesomePath)
    {
        $this->fontAwesomePath = $fontAwesomePath;
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

        return file_get_contents($fileName);
    }
}
