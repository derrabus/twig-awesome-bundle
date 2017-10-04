<?php

namespace Rabus\TwigAwesomeBundle;

use PHPUnit\Framework\TestCase;
use Rabus\TwigAwesomeBundle\Twig\FaExtension;
use Rabus\TwigAwesomeBundle\Twig\FaTokenParser;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigAwesomeTest extends TestCase
{
    public function testNodeIsConvertedToSvg()
    {
        $twig = $this->createTwigInstance();

        $this->assertStringEqualsFile(
            __DIR__.'/fixtures/flag.html',
            $twig->render('flag.html.twig')
        );
    }

    private function createTwigInstance(): Environment
    {
        $twig = new Environment(new FilesystemLoader(['fixtures'], __DIR__));
        $twig->addExtension(
            new FaExtension(
                new FaTokenParser(
                    new IconLocator(dirname(__DIR__).'/vendor/fortawesome/font-awesome')
                )
            )
        );

        return $twig;
    }
}
