<?php

// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/user')]
class UserController extends AbstractController
{
    private $entityManager;
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->json($users);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return $this->json($user);
    }

    #[Route('/new', name: 'user_new', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json($user);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $user->setEmail($data['email']);
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->flush();

        return $this->json($user);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'Utilisateur supprimé']);
    }
}
