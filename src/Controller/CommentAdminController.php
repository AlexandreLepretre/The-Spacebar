<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentAdminController
 * @package App\Controller
 */
class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     * @param CommentRepository $repository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $queryBuilder = $repository->getWithSearchQueryBuilder($request->query->get('q'));
        /** @var SlidingPagination $pagination */
        $pagination = $paginator->paginate($queryBuilder, $request->query->getInt('page', 1), 10);
        return $this->render('comment_admin/index.html.twig', ['pagination' => $pagination]);
    }
}
