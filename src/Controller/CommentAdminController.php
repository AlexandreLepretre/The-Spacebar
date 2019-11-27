<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return Response
     */
    public function index(CommentRepository $repository, Request $request)
    {
        $comments = $repository->findAllWithSearch($request->query->get('q'));
        return $this->render('comment_admin/index.html.twig', ['comments' => $comments]);
    }
}
