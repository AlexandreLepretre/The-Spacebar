<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CommentAdminController
 * @package App\Controller
 */
class CommentAdminController extends Controller
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     * @param CommentRepository $repository
     * @return Response
     */
    public function index(CommentRepository $repository)
    {
        $comments = $repository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('comment_admin/index.html.twig', ['comments' => $comments]);
    }
}
