<?php

namespace App\Controller;

use App\Entity\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/')]
    public function index(UserRepository $userRepository){

    }
}
