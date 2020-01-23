<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class MarkdownHelper
 * @package App\Service
 */
class MarkdownHelper
{
    /**
     * @var AdapterInterface
     */
    private AdapterInterface $cache;

    /**
     * @var MarkdownInterface
     */
    private MarkdownInterface $markdown;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var bool
     */
    private bool $isDebug;

    /**
     * @var Security
     */
    private Security $security;

    /**
     * MarkdownHelper constructor.
     * @param AdapterInterface $cache
     * @param MarkdownInterface $markdown
     * @param LoggerInterface $markdownLogger
     * @param bool $isDebug
     * @param Security $security
     */
    public function __construct(
        AdapterInterface $cache,
        MarkdownInterface $markdown,
        LoggerInterface $markdownLogger,
        bool $isDebug,
        Security $security
    ) {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
        $this->isDebug = $isDebug;
        $this->security = $security;
    }

    /**
     * @param string $source
     * @return string
     * @throws InvalidArgumentException
     */
    public function parse(string $source): string
    {
        if (stripos($source, 'bacon') !== false) {
            $this->logger->info('They are talking about bacon again!', ['user' => $this->security->getUser()]);
        }

        // skip caching entirely in debug
        if ($this->isDebug) {
            return $this->markdown->transform($source);
        }

        $item = $this->cache->getItem('markdown_' . md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
