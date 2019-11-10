<?php

namespace App\Controller;

use App\Entity\SortieArticle;
use App\Form\SortieArticleType;
use App\Repository\SortieArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie/article")
 */
class SortieArticleController extends AbstractController
{
    /**
     * @Route("/", name="sortie_article_index", methods={"GET"})
     */
    public function index(SortieArticleRepository $sortieArticleRepository): Response
    {
        return $this->render('sortie_article/index.html.twig', [
            'sortie_articles' => $sortieArticleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sortie_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sortieArticle = new SortieArticle();
        $form = $this->createForm(SortieArticleType::class, $sortieArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sortieArticle);
            $entityManager->flush();

            return $this->redirectToRoute('sortie_article_index');
        }

        return $this->render('sortie_article/new.html.twig', [
            'sortie_article' => $sortieArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_article_show", methods={"GET"})
     */
    public function show(SortieArticle $sortieArticle): Response
    {
        return $this->render('sortie_article/show.html.twig', [
            'sortie_article' => $sortieArticle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sortie_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SortieArticle $sortieArticle): Response
    {
        $form = $this->createForm(SortieArticleType::class, $sortieArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sortie_article_index');
        }

        return $this->render('sortie_article/edit.html.twig', [
            'sortie_article' => $sortieArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sortie_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SortieArticle $sortieArticle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortieArticle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sortieArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sortie_article_index');
    }
}
