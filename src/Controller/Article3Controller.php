<?php

namespace App\Controller;

use App\Entity\Article3;
use App\Form\Article3Type;
use App\Repository\Article3Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article3')]
class Article3Controller extends AbstractController
{
    #[Route('/', name: 'app_article3_index', methods: ['GET'])]
    public function index(Article3Repository $article3Repository): Response
    {
        return $this->render('article3/index.html.twig', [
            'article3s' => $article3Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article3_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article3 = new Article3();
        $form = $this->createForm(Article3Type::class, $article3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article3);
            $entityManager->flush();

            return $this->redirectToRoute('app_article3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article3/new.html.twig', [
            'article3' => $article3,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article3_show', methods: ['GET'])]
    public function show(Article3 $article3): Response
    {
        return $this->render('article3/show.html.twig', [
            'article3' => $article3,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article3_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article3 $article3, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Article3Type::class, $article3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article3/edit.html.twig', [
            'article3' => $article3,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article3_delete', methods: ['POST'])]
    public function delete(Request $request, Article3 $article3, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article3->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article3);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article3_index', [], Response::HTTP_SEE_OTHER);
    }
}
