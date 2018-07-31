<?php

namespace Rabus\TwigAwesomeBundle\DependencyInjection;

use Rabus\TwigAwesomeBundle\Exception\RuntimeException;
use Rabus\TwigAwesomeBundle\IconLocator;
use Rabus\TwigAwesomeBundle\Twig\FaExtension;
use Rabus\TwigAwesomeBundle\Twig\FaTokenParser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class TwigAwesomeExtension extends Extension
{
    const PACKAGE_NAME = 'fortawesome/font-awesome';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $iconLocator = (new Definition(IconLocator::class, [$this->determineFaPath()]))
            ->addMethodCall('setLogger', [new Reference('logger', ContainerInterface::IGNORE_ON_INVALID_REFERENCE)]);

        $tokenParser = new Definition(FaTokenParser::class, [$iconLocator]);

        $container->register('twig_awesome_extension', FaExtension::class)
            ->setArguments([$tokenParser])
            ->setPublic(false)
            ->addTag('twig.extension')
        ;
    }

    private function determineFaPath(): string
    {
        $guessedPaths = [
            dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.self::PACKAGE_NAME,
            dirname(__DIR__, 4).DIRECTORY_SEPARATOR.self::PACKAGE_NAME,
        ];

        foreach ($guessedPaths as $current) {
            if (file_exists($current)) {
                return $current;
            }
        }

        throw new RuntimeException('Unable to locate FontAwesome.');
    }
}
