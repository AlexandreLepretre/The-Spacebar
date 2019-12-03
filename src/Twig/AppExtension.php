<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class AppExtension
 * @package App\Twig
 */
class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * AppExtension constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']]),];
    }

    /**
     * @param $value
     * @return string
     */
    public function processMarkdown($value)
    {
        return $this->container->get(MarkdownHelper::class)
            ->parse($value);
    }

    /**
     * @return array
     */
    public static function getSubscribedServices()
    {
        return [MarkdownHelper::class,];
    }
}
