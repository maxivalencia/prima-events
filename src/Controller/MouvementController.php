<?php

namespace App\Controller;

use App\Entity\Mouvement;
use App\Form\MouvementType;
use App\Repository\MouvementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/mouvement")
 */
class MouvementController extends AbstractController
{
    /**
     * @Route("/", name="mouvement_index", methods={"GET"})
     */
    public function index(MouvementRepository $mouvementRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $mouvementRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('mouvement/index.html.twig', [
            'mouvements' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="mouvement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mouvement = new Mouvement();
        $form = $this->createForm(MouvementType::class, $mouvement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mouvement);
            $entityManager->flush();

            return $this->redirectToRoute('mouvement_index');
        }

        return $this->render('mouvement/new.html.twig', [
            'mouvement' => $mouvement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mouvement_show", methods={"GET"})
     */
    public function show(Mouvement $mouvement): Response
    {
        return $this->render('mouvement/show.html.twig', [
            'mouvement' => $mouvement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mouvement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mouvement $mouvement): Response
    {
        $form = $this->createForm(MouvementType::class, $mouvement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mouvement_index');
        }

        return $this->render('mouvement/edit.html.twig', [
            'mouvement' => $mouvement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mouvement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mouvement $mouvement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mouvement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mouvement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mouvement_index');
    }
}
