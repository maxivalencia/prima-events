<?php

namespace App\Controller;

use App\Entity\MotifPayement;
use App\Form\MotifPayementType;
use App\Repository\MotifPayementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/motif/payement")
 */
class MotifPayementController extends AbstractController
{
    /**
     * @Route("/", name="motif_payement_index", methods={"GET"})
     */
    public function index(MotifPayementRepository $motifPayementRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $motifPayementRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('motif_payement/index.html.twig', [
            'motif_payements' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="motif_payement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $motifPayement = new MotifPayement();
        $form = $this->createForm(MotifPayementType::class, $motifPayement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($motifPayement);
            $entityManager->flush();

            return $this->redirectToRoute('motif_payement_index');
        }

        return $this->render('motif_payement/new.html.twig', [
            'motif_payement' => $motifPayement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="motif_payement_show", methods={"GET"})
     */
    public function show(MotifPayement $motifPayement): Response
    {
        return $this->render('motif_payement/show.html.twig', [
            'motif_payement' => $motifPayement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="motif_payement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MotifPayement $motifPayement): Response
    {
        $form = $this->createForm(MotifPayementType::class, $motifPayement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('motif_payement_index');
        }

        return $this->render('motif_payement/edit.html.twig', [
            'motif_payement' => $motifPayement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="motif_payement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MotifPayement $motifPayement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$motifPayement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($motifPayement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('motif_payement_index');
    }
}
