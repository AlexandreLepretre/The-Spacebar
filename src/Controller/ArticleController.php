<?php


namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     * @param string $slug
     * @return Response
     */
    public function show($slug)
    {
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        dump($slug, $this);

        return $this->render(
            'article/show.html.twig',
            ['title' => ucwords(str_replace('-', ' ', $slug)), 'comments' => $comments, 'slug' => $slug]
        );
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @param string $slug
     * @param LoggerInterface $logger
     * @return JsonResponse
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        // TODO - actually heart/unheart the article!
        $logger->info(sprintf('Article %s is being hearted', $slug));
        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}
