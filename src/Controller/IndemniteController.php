<?php

namespace App\Controller;

use App\Entity\Indemnite;
use App\Form\IndemniteType;
use App\Repository\IndemniteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/indemnite")
 */
class IndemniteController extends AbstractController
{
    /**
     * @Route("/", name="indemnite_index", methods={"GET"})
     */
    public function index(IndemniteRepository $indemniteRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $indemniteRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('indemnite/index.html.twig', [
            'indemnites' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="indemnite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $indemnite = new Indemnite();
        $form = $this->createForm(IndemniteType::class, $indemnite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($indemnite);
            $entityManager->flush();

            return $this->redirectToRoute('indemnite_index');
        }

        return $this->render('indemnite/new.html.twig', [
            'indemnite' => $indemnite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="indemnite_show", methods={"GET"})
     */
    public function show(Indemnite $indemnite): Response
    {
        return $this->render('indemnite/show.html.twig', [
            'indemnite' => $indemnite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="indemnite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Indemnite $indemnite): Response
    {
        $form = $this->createForm(IndemniteType::class, $indemnite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('indemnite_index');
        }

        return $this->render('indemnite/edit.html.twig', [
            'indemnite' => $indemnite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="indemnite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Indemnite $indemnite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$indemnite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($indemnite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('indemnite_index');
    }
}
