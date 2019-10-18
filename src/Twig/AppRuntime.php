<?php


namespace App\Twig;


use App\Service\MarkdownHelper;
use Psr\Cache\InvalidArgumentException;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Class AppRuntime
 * @package App\Twig
 */
class AppRuntime implements RuntimeExtensionInterface
{
    /**
     * @var MarkdownHelper
     */
    private $markdownHelper;

    /**
     * AppRuntime constructor.
     * @param MarkdownHelper $markdownHelper
     */
    public function __construct(MarkdownHelper $markdownHelper)
    {
        $this->markdownHelper = $markdownHelper;
    }

    /**
     * @param string $value
     * @return string
     * @throws InvalidArgumentException
     */
    public function processMarkdown(string $value): string
    {
        return $this->markdownHelper->parse($value);
    }
}