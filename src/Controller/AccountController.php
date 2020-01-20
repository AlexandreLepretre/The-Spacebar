<?php

namespace App\Controller;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller
 * @method User getUser()
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(LoggerInterface $logger)
    {
        $logger->debug(sprintf('Checking account page for %s', $this->getUser()->getEmail()));

        return $this->render('account/index.html.twig', ['controller_name' => 'AccountController',]);
    }
}
