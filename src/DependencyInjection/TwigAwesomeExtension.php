<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle\DependencyInjection;

use Composer\InstalledVersions;
use Rabus\TwigAwesomeBundle\IconLocator;
use Rabus\TwigAwesomeBundle\Twig\FaExtension;
use Rabus\TwigAwesomeBundle\Twig\FaTokenParser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class TwigAwesomeExtension extends Extension
{
    private const PACKAGE_NAME = 'fortawesome/font-awesome';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $iconLocator = new Definition(IconLocator::class, [$this->determineFaPath()]);
        $tokenParser = new Definition(FaTokenParser::class, [$iconLocator]);

        $container->register('twig_awesome_extension', FaExtension::class)
            ->setArguments([$tokenParser])
            ->setPublic(false)
            ->addTag('twig.extension')
        ;
    }

    private function determineFaPath(): string
    {
        return realpath(InstalledVersions::getInstallPath(self::PACKAGE_NAME));
    }
}
