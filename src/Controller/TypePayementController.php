<?php

namespace App\Controller;

use App\Entity\TypePayement;
use App\Form\TypePayementType;
use App\Repository\TypePayementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/payement")
 */
class TypePayementController extends AbstractController
{
    /**
     * @Route("/", name="type_payement_index", methods={"GET"})
     */
    public function index(TypePayementRepository $typePayementRepository): Response
    {
        return $this->render('type_payement/index.html.twig', [
            'type_payements' => $typePayementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_payement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typePayement = new TypePayement();
        $form = $this->createForm(TypePayementType::class, $typePayement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typePayement);
            $entityManager->flush();

            return $this->redirectToRoute('type_payement_index');
        }

        return $this->render('type_payement/new.html.twig', [
            'type_payement' => $typePayement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_payement_show", methods={"GET"})
     */
    public function show(TypePayement $typePayement): Response
    {
        return $this->render('type_payement/show.html.twig', [
            'type_payement' => $typePayement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_payement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypePayement $typePayement): Response
    {
        $form = $this->createForm(TypePayementType::class, $typePayement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_payement_index');
        }

        return $this->render('type_payement/edit.html.twig', [
            'type_payement' => $typePayement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_payement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypePayement $typePayement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePayement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typePayement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_payement_index');
    }
}
