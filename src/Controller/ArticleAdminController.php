<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleAdminController
 * @package App\Controller
 */
class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws Exception
     */
    public function new(EntityManagerInterface $entityManager)
    {
        die('todo');
        return new Response(sprintf('Hiya! New article id: #%d slug: %s', $article->getId(), $article->getSlug()));
    }
}