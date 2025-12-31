<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle;

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

final class IconLocatorTest extends TestCase
{
    #[DoesNotPerformAssertions]
    public function testValidConstructorCall(): void
    {
        // @phpstan-ignore new.resultUnused
        new IconLocator('/tmp/foo', self::createStub(Filesystem::class));
    }
}
