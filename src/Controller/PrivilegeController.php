<?php

namespace App\Controller;

use App\Entity\Privilege;
use App\Form\PrivilegeType;
use App\Repository\PrivilegeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/privilege")
 */
class PrivilegeController extends AbstractController
{
    /**
     * @Route("/", name="privilege_index", methods={"GET"})
     */
    public function index(PrivilegeRepository $privilegeRepository): Response
    {
        return $this->render('privilege/index.html.twig', [
            'privileges' => $privilegeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="privilege_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $privilege = new Privilege();
        $form = $this->createForm(PrivilegeType::class, $privilege);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privilege);
            $entityManager->flush();

            return $this->redirectToRoute('privilege_index');
        }

        return $this->render('privilege/new.html.twig', [
            'privilege' => $privilege,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="privilege_show", methods={"GET"})
     */
    public function show(Privilege $privilege): Response
    {
        return $this->render('privilege/show.html.twig', [
            'privilege' => $privilege,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="privilege_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Privilege $privilege): Response
    {
        $form = $this->createForm(PrivilegeType::class, $privilege);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('privilege_index');
        }

        return $this->render('privilege/edit.html.twig', [
            'privilege' => $privilege,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="privilege_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Privilege $privilege): Response
    {
        if ($this->isCsrfTokenValid('delete'.$privilege->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($privilege);
            $entityManager->flush();
        }

        return $this->redirectToRoute('privilege_index');
    }
}
