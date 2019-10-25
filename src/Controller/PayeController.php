<?php

namespace App\Controller;

use App\Entity\Paye;
use App\Form\PayeType;
use App\Repository\PayeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paye")
 */
class PayeController extends AbstractController
{
    /**
     * @Route("/", name="paye_index", methods={"GET"})
     */
    public function index(PayeRepository $payeRepository): Response
    {
        return $this->render('paye/index.html.twig', [
            'payes' => $payeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="paye_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paye = new Paye();
        $form = $this->createForm(PayeType::class, $paye);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paye);
            $entityManager->flush();

            return $this->redirectToRoute('paye_index');
        }

        return $this->render('paye/new.html.twig', [
            'paye' => $paye,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paye_show", methods={"GET"})
     */
    public function show(Paye $paye): Response
    {
        return $this->render('paye/show.html.twig', [
            'paye' => $paye,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="paye_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paye $paye): Response
    {
        $form = $this->createForm(PayeType::class, $paye);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paye_index');
        }

        return $this->render('paye/edit.html.twig', [
            'paye' => $paye,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paye_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Paye $paye): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paye->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paye);
            $entityManager->flush();
        }

        return $this->redirectToRoute('paye_index');
    }
}
