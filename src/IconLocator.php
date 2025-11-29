<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle;

use Rabus\TwigAwesomeBundle\Exception\InvalidArgumentException;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

final readonly class IconLocator
{
    public function __construct(
        private string $fontAwesomePath,
        private Filesystem $filesystem = new Filesystem(),
    ) {
        if (\func_num_args() < 2) {
            trigger_deprecation('derrabus/twig-awesome-bundle', '4.5', 'Not passing an instance of %s as second argument when constructing %s is deprecated.', Filesystem::class, self::class);
        }
    }

    public function getSvg(string $collection, string $id): string
    {
        $fileName = implode(\DIRECTORY_SEPARATOR, [
            $this->fontAwesomePath,
            'svgs',
            $collection,
            $id.'.svg',
        ]);

        try {
            return $this->filesystem->readFile($fileName);
        } catch (IOExceptionInterface $e) {
            throw new InvalidArgumentException(\sprintf('Could not find the requested glyph: %s of collection %s.', $id, $collection), previous: $e);
        }
    }
}
