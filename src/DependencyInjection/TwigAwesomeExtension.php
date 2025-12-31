<?php

declare(strict_types=1);

namespace Rabus\TwigAwesomeBundle\DependencyInjection;

use Composer\InstalledVersions;
use Rabus\TwigAwesomeBundle\Exception\RuntimeException;
use Rabus\TwigAwesomeBundle\IconLocator;
use Rabus\TwigAwesomeBundle\Twig\FaExtension;
use Rabus\TwigAwesomeBundle\Twig\FaTokenParser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

final class TwigAwesomeExtension extends Extension
{
    private const string PACKAGE_NAME = 'fortawesome/font-awesome';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $iconLocator = new Definition(IconLocator::class, [$this->determineFaPath(), new Reference('filesystem')]);
        $tokenParser = new Definition(FaTokenParser::class, [$iconLocator]);

        $container->register('twig_awesome_extension', FaExtension::class)
            ->setArguments([$tokenParser])
            ->setPublic(false)
            ->addTag('twig.extension')
        ;
    }

    private function determineFaPath(): string
    {
        $path = InstalledVersions::getInstallPath(self::PACKAGE_NAME)
            ?? throw new RuntimeException('Unable to determine FontAwesome\'s installation path.');

        if (false === $realpath = realpath($path)) {
            throw new RuntimeException('Unable to determine FontAwesome\'s installation path.');
        }

        return $realpath;
    }
}
