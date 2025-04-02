<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle;

use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

final class IconLocatorTest extends TestCase
{
    #[IgnoreDeprecations]
    public function testDeprecatedConstructor(): void
    {
        $this->expectUserDeprecationMessage('Since derrabus/twig-awesome-bundle 4.5: Not passing an instance of Symfony\Component\Filesystem\Filesystem as second argument when constructing Rabus\TwigAwesomeBundle\IconLocator is deprecated.');

        new IconLocator('/tmp/foo');
    }

    public function testValidConstructorCall(): void
    {
        $this->expectNotToPerformAssertions();

        new IconLocator('/tmp/foo', self::createStub(Filesystem::class));
    }
}
