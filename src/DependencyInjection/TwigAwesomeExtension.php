<?php

namespace Rabus\TwigAwesomeBundle\DependencyInjection;

use Psr\Log\LoggerInterface;
use Rabus\TwigAwesomeBundle\Exception\RuntimeException;
use Rabus\TwigAwesomeBundle\IconLocator;
use Rabus\TwigAwesomeBundle\Twig\FaExtension;
use Rabus\TwigAwesomeBundle\Twig\FaTokenParser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
        $container->register(IconLocator::class)
            ->setPublic(false)
            ->setArgument('$fontAwesomePath', $this->determineFaPath())
            ->addMethodCall('setLogger', [new Reference(LoggerInterface::class, ContainerInterface::IGNORE_ON_INVALID_REFERENCE)]);

        $container->register(FaTokenParser::class)
            ->setPublic(false)
            ->setAutowired(true);

        $container->register(FaExtension::class)
            ->setPublic(false)
            ->setAutowired(true)
            ->setAutoconfigured(true);
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
