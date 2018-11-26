<?php

namespace Rabus\TwigAwesomeBundle;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;
use Twig\Environment;

class TwigAwesomeTest extends TestCase
{
    public function testNodeIsConvertedToSvg(): void
    {
        $twig = $this->createTwigInstance();

        $this->assertStringEqualsFile(
            __DIR__.'/fixtures/flag.html',
            $twig->render('flag.html.twig')
        );
    }

    protected function tearDown(): void
    {
        $fs = new Filesystem();
        $fs->remove(__DIR__.'/temp');
    }

    private function createTwigInstance(): Environment
    {
        $fs = new Filesystem();
        $fs->remove(__DIR__.'/temp');

        $kernel = new class('prod', false) extends Kernel {
            public function registerBundles()
            {
                return [new FrameworkBundle(), new TwigBundle(), new TwigAwesomeBundle()];
            }

            public function registerContainerConfiguration(LoaderInterface $loader)
            {
                $loader->load(function (ContainerBuilder $container) use ($loader) {
                    $container->loadFromExtension('framework', [
                        'secret' => 'foo',
                    ]);
                    $container->loadFromExtension('twig', [
                        'default_path' => __DIR__.'/fixtures',
                    ]);
                });
            }

            public function getRootDir()
            {
                if (!$this->rootDir) {
                    $this->rootDir = __DIR__.'/temp';
                }

                return parent::getRootDir();
            }

            public function getProjectDir()
            {
                return __DIR__.'/temp';
            }
        };

        $kernel->boot();

        return $kernel->getContainer()->get('twig');
    }
}
