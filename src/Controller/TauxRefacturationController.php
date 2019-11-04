<?php

namespace App\Controller;

use App\Entity\TauxRefacturation;
use App\Form\TauxRefacturationType;
use App\Repository\TauxRefacturationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/taux/refacturation")
 */
class TauxRefacturationController extends AbstractController
{
    /**
     * @Route("/", name="taux_refacturation_index", methods={"GET"})
     */
    public function index(TauxRefacturationRepository $tauxRefacturationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $tauxRefacturationRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('taux_refacturation/index.html.twig', [
            'taux_refacturations' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="taux_refacturation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tauxRefacturation = new TauxRefacturation();
        $form = $this->createForm(TauxRefacturationType::class, $tauxRefacturation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tauxRefacturation);
            $entityManager->flush();

            return $this->redirectToRoute('taux_refacturation_index');
        }

        return $this->render('taux_refacturation/new.html.twig', [
            'taux_refacturation' => $tauxRefacturation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="taux_refacturation_show", methods={"GET"})
     */
    public function show(TauxRefacturation $tauxRefacturation): Response
    {
        return $this->render('taux_refacturation/show.html.twig', [
            'taux_refacturation' => $tauxRefacturation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="taux_refacturation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TauxRefacturation $tauxRefacturation): Response
    {
        $form = $this->createForm(TauxRefacturationType::class, $tauxRefacturation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taux_refacturation_index');
        }

        return $this->render('taux_refacturation/edit.html.twig', [
            'taux_refacturation' => $tauxRefacturation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="taux_refacturation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TauxRefacturation $tauxRefacturation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tauxRefacturation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tauxRefacturation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('taux_refacturation_index');
    }
}
