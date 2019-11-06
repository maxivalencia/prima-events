<?php

namespace App\Controller;

use App\Entity\Remise;
use App\Form\RemiseType;
use App\Repository\RemiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/remise")
 */
class RemiseController extends AbstractController
{
    /**
     * @Route("/", name="remise_index", methods={"GET"})
     */
    public function index(RemiseRepository $remiseRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $remiseRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('remise/index.html.twig', [
            'remises' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="remise_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $remise = new Remise();
        $form = $this->createForm(RemiseType::class, $remise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($remise);
            $entityManager->flush();

            return $this->redirectToRoute('remise_index');
        }

        return $this->render('remise/new.html.twig', [
            'remise' => $remise,
            'form2' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="remise_show", methods={"GET"})
     */
    public function show(Remise $remise): Response
    {
        return $this->render('remise/show.html.twig', [
            'remise' => $remise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="remise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Remise $remise): Response
    {
        $form = $this->createForm(RemiseType::class, $remise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('remise_index');
        }

        return $this->render('remise/edit.html.twig', [
            'remise' => $remise,
            'form2' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="remise_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Remise $remise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$remise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($remise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('remise_index');
    }
}
