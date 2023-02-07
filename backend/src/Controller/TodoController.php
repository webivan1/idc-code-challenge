<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/todo')]
class TodoController extends AbstractController
{
    #[Route(methods: ['GET'])]
    public function index(TodoRepository $todoRepository)
    {
        return $this->json([
            'user' => $this->getUser(),
            'todoList' => $todoRepository->findBy(['owner' => $this->getUser()]),
        ]);
    }

    #[Route(methods: ['PUT'])]
    public function new(Request $request, TodoRepository $todoRepository): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $todo = new Todo();
        $todo->setTitle($requestData['title']);
        $todo->setIsDone(false);
        $todo->setOwner($this->getUser());
        $todo->setCreatedAt(new \DateTimeImmutable());
        $todo->setUpdatedAt(new \DateTimeImmutable());

        $todoRepository->save($todo, true);

        return $this->json([
            'todo' => $todo,
        ]);
    }

    #[Route('/{id}', methods: ['POST'])]
    public function edit(Request $request, Todo $todo, TodoRepository $todoRepository): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $todo->setIsDone(boolval($requestData['isDone']));

        $todoRepository->save($todo, true);

        return $this->json([
            'todo' => $todo,
        ]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Request $request, Todo $todo, TodoRepository $todoRepository): JsonResponse
    {
        $todoRepository->remove($todo, true);

        return $this->json(['message' => 'Todo was removed']);
    }
}
