<?php
declare(strict_types=0);

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category')]
class CategoryController extends AbstractController
{
    #[Route('/summary', methods: ['GET'])]
    public function summary(Request $request, CategoryRepository $c_repo, TodoRepository $t_repo): mixed {
        $r = [];

        // @todo need some optimisation
        foreach ($c_repo->findAll() as $c) {
            $item = ['category' => $c, 'todoCount' => 0];

            foreach ($t_repo->findBy(['category' => $c]) as $t) {
                $item['todoCount']++;
            }

            array_push($r, $item);
        }

        return $this->json($r);
    }

    #[Route('/{slug}', methods: ['GET'])]
    public function one(Category $category): mixed
    {
        return $this->json($category);
    }
}
