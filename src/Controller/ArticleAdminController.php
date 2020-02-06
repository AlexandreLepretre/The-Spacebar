<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleAdminController
 * @package App\Controller
 */
class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new()
    {
        die('todo');
    }

    /**
     * @Route("/admin/article/{id}/edit")
     * @param Article $article
     */
    public function edit(Article $article)
    {
        if (!$this->isGranted('MANAGE', $article)) {
            throw $this->createAccessDeniedException('No access!');
        }

        dd($article);
    }
}
