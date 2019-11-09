<?php

namespace App\Controller;

use App\Entity\Caution;
use App\Form\CautionType;
use App\Repository\CautionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/caution")
 */
class CautionController extends AbstractController
{
    /**
     * @Route("/", name="caution_index", methods={"GET"})
     */
    public function index(CautionRepository $cautionRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $cautionRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('caution/index.html.twig', [
            'cautions' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="caution_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $caution = new Caution();
        $form = $this->createForm(CautionType::class, $caution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($caution);
            $entityManager->flush();

            return $this->redirectToRoute('caution_index');
        }

        return $this->render('caution/new.html.twig', [
            'caution' => $caution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="caution_show", methods={"GET"})
     */
    public function show(Caution $caution): Response
    {
        return $this->render('caution/show.html.twig', [
            'caution' => $caution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="caution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Caution $caution): Response
    {
        $form = $this->createForm(CautionType::class, $caution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('caution_index');
        }

        return $this->render('caution/edit.html.twig', [
            'caution' => $caution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="caution_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Caution $caution): Response
    {
        if ($this->isCsrfTokenValid('delete'.$caution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($caution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('caution_index');
    }
}
