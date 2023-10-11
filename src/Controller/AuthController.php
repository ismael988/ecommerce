<?php

// src/Controller/AuthController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Repository\UserRepository;

class AuthController extends AbstractController
{
    public function getToken(Request $request, UserRepository $userRepository, JWTTokenManagerInterface $JWTManager)
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // Vérifiez les identifiants de l'utilisateur ici
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return new JsonResponse(['message' => 'Invalid credentials'], 401);
        }

        // Générez le token JWT
        $token = $JWTManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}

