<?php

namespace App\Controller;

use App\Repository\ClientEntityRepository;
use App\Repository\ProductEntityRepository;
use App\Repository\UserEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        UserEntityRepository $userRepository,
        ClientEntityRepository $clientRepository,
        ProductEntityRepository $productRepository
    ): Response
    {
        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'stats' => [
                'users' => $userRepository->count([]),
                'clients' => $clientRepository->count([]),
                'products' => $productRepository->count([]),
            ]
        ]);
    }
}