<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ApiClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index')]
    public function index(
        EntityManagerInterface $entityManager
    ): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        return $this->render('index.html.twig', [
            'users' => $users,
        ]);
    }


    #[Route('/', name: 'app_home_index')]
    public function index(
    EntityManagerInterface $entityManager,
    TmdbService $tmdbService // Injection du service
): Response
{
    $users = $entityManager->getRepository(User::class)->findAll();

    // Récupération des films via l'API
    $moviesData = $tmdbService->getPopularMovies();

    return $this->render('index.html.twig', [
        'users' => $users,
        'movies' => $moviesData['results'] ?? [],
        ]);
}
}

