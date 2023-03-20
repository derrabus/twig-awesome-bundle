<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;
use Twig\Environment;

final class TwigAwesomeTest extends TestCase
{
    protected function setUp(): void
    {
        $fs = new Filesystem();
        $fs->remove(__DIR__.'/temp');
    }

    protected function tearDown(): void
    {
        $fs = new Filesystem();
        $fs->remove(__DIR__.'/temp');
    }

    public function testNodeIsConvertedToSvg(): void
    {
        $twig = $this->createTwigInstance();

        $this->assertStringMatchesFormatFile(
            __DIR__.'/fixtures/flag.html',
            $twig->render('flag.html.twig')
        );
    }

    private function createTwigInstance(): Environment
    {
        $kernel = new class('prod', false) extends Kernel {
            public function registerBundles(): iterable
            {
                return [new FrameworkBundle(), new TwigBundle(), new TwigAwesomeBundle()];
            }

            public function registerContainerConfiguration(LoaderInterface $loader): void
            {
                $loader->load(static function (ContainerBuilder $container): void {
                    $container->loadFromExtension('framework', [
                        'secret' => 'foo',
                        'http_method_override' => false,
                        'annotations' => ['enabled' => false],
                    ]);

                    $twigConfig = [
                        'default_path' => __DIR__.'/fixtures',
                        'strict_variables' => true,
                    ];

                    $container->loadFromExtension('twig', $twigConfig);

                    $container->setAlias('test.twig', 'twig')
                        ->setPublic(true)
                    ;
                });
            }

            public function getProjectDir(): string
            {
                return __DIR__.'/temp';
            }

            protected function getContainerClass(): string
            {
                return 'testContainer';
            }
        };

        $kernel->boot();

        $twig = $kernel->getContainer()->get('test.twig');
        \assert($twig instanceof Environment);

        return $twig;
    }
}
