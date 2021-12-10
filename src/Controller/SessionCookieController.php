<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class SessionCookieController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
    ){}

    #[Route('/', name: 'session_cookie')]
    public function index(): Response
    {
        return $this->json($this->requestStack->getSession()->getId());
    }
}
