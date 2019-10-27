<?php

namespace App\Controller;

use App\Entity\TVA;
use App\Form\TVAType;
use App\Repository\TVARepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/t/v/a")
 */
class TVAController extends AbstractController
{
    /**
     * @Route("/", name="t_v_a_index", methods={"GET"})
     */
    public function index(TVARepository $tVARepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $tVARepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('tva/index.html.twig', [
            't_v_as' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="t_v_a_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tVA = new TVA();
        $form = $this->createForm(TVAType::class, $tVA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tVA);
            $entityManager->flush();

            return $this->redirectToRoute('t_v_a_index');
        }

        return $this->render('tva/new.html.twig', [
            't_v_a' => $tVA,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="t_v_a_show", methods={"GET"})
     */
    public function show(TVA $tVA): Response
    {
        return $this->render('tva/show.html.twig', [
            't_v_a' => $tVA,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="t_v_a_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TVA $tVA): Response
    {
        $form = $this->createForm(TVAType::class, $tVA);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('t_v_a_index');
        }

        return $this->render('tva/edit.html.twig', [
            't_v_a' => $tVA,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="t_v_a_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TVA $tVA): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tVA->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tVA);
            $entityManager->flush();
        }

        return $this->redirectToRoute('t_v_a_index');
    }
}
