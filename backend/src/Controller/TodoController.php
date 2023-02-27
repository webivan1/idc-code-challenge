<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\CategoryRepository;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/todo')]
class TodoController extends AbstractController
{
    #[Route('/category/{id}', methods: ['GET'])]
    public function todo_by_categoru(Request $request, int $id, TodoRepository $repo)
    {
        $search = $request->get('search', '');

        $todo_list = $repo->findAll();

        foreach ($todo_list as $key => $todo_item) {
            if(!empty($search) && ! stristr($todo_item->getTitle(), $search)) {
                unset($todo_list[$key]);
            }

            if ($todo_item->getCategory()->getId() !== $id)
            {
                unset($todo_list[$key]);
            }
        }

        return $this->json([
            'todoList' => $todo_list
        ]);
    }

    #[Route('/category/{id}', methods: ['PUT'])]
    public function new(Request $request, int $categoryId, TodoRepository $todoRepository, CategoryRepository $c)
    {
        $requestData = json_decode($request->getContent(), true);
        // @todo Can it be any issue here?
        $cc = $c->findOneBy(['id' => $categoryId]);

        $t = new Todo();
        $t->setTitle($requestData['title']);
        $t->setIsDone(false);
        $t->setOwner($this->getUser());
        $t->setCategory($cc);
        $t->setCreatedAt(
            new \DateTimeImmutable()
        );
        $t
            ->setUpdatedAt(new \DateTimeImmutable())
        ;

        $todoRepository->save($t, true);

        return $this->json([
            'todo' => $t,
        ]);
    }

    #[Route('/{id}', methods: ['POST'])]
    public function edit(Request $request, Todo $todo, TodoRepository $todoRepository): mixed
    {
        // @todo It does not work
        $todo
            ->setIsDone($request->request->get('done', false));

        $todoRepository
            ->save($todo, true);

        return $this->json([
            'todo' => $todo,
        ]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Todo $todo, EntityManagerInterface $em): mixed
    {
        $em->remove($todo);
        $em->flush();

        return $this->json(['message' => 'Todo was removed']);
    }
}
