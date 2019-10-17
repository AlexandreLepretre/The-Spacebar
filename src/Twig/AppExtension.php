<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Psr\Cache\InvalidArgumentException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var MarkdownHelper
     */
    private $helper;

    /**
     * AppExtension constructor.
     * @param MarkdownHelper $helper
     */
    public function __construct(MarkdownHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']])];
    }

    /**
     * @param string $value
     * @return string
     * @throws InvalidArgumentException
     */
    public function processMarkdown(string $value): string
    {
        return $this->helper->parse($value);
    }
}
