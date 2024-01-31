<?php

namespace App\Controller;

use App\Entity\Article2;
use App\Form\Article2Type;
use App\Repository\Article2Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article2')]
class Article2Controller extends AbstractController
{
    #[Route('/', name: 'app_article2_index', methods: ['GET'])]
    public function index(Article2Repository $article2Repository): Response
    {
        return $this->render('article2/index.html.twig', [
            'article2s' => $article2Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article2 = new Article2();
        $form = $this->createForm(Article2Type::class, $article2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article2);
            $entityManager->flush();

            return $this->redirectToRoute('app_article2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article2/new.html.twig', [
            'article2' => $article2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article2_show', methods: ['GET'])]
    public function show(Article2 $article2): Response
    {
        return $this->render('article2/show.html.twig', [
            'article2' => $article2,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article2 $article2, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Article2Type::class, $article2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article2/edit.html.twig', [
            'article2' => $article2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article2_delete', methods: ['POST'])]
    public function delete(Request $request, Article2 $article2, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article2->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article2_index', [], Response::HTTP_SEE_OTHER);
    }
}
