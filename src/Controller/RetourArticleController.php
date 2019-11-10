<?php

namespace App\Controller;

use App\Entity\RetourArticle;
use App\Form\RetourArticleType;
use App\Repository\RetourArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/retour/article")
 */
class RetourArticleController extends AbstractController
{
    /**
     * @Route("/", name="retour_article_index", methods={"GET"})
     */
    public function index(RetourArticleRepository $retourArticleRepository): Response
    {
        return $this->render('retour_article/index.html.twig', [
            'retour_articles' => $retourArticleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="retour_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $retourArticle = new RetourArticle();
        $form = $this->createForm(RetourArticleType::class, $retourArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($retourArticle);
            $entityManager->flush();

            return $this->redirectToRoute('retour_article_index');
        }

        return $this->render('retour_article/new.html.twig', [
            'retour_article' => $retourArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="retour_article_show", methods={"GET"})
     */
    public function show(RetourArticle $retourArticle): Response
    {
        return $this->render('retour_article/show.html.twig', [
            'retour_article' => $retourArticle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="retour_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RetourArticle $retourArticle): Response
    {
        $form = $this->createForm(RetourArticleType::class, $retourArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('retour_article_index');
        }

        return $this->render('retour_article/edit.html.twig', [
            'retour_article' => $retourArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="retour_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RetourArticle $retourArticle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$retourArticle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($retourArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('retour_article_index');
    }
}
