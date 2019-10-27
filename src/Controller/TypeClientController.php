<?php

namespace App\Controller;

use App\Entity\TypeClient;
use App\Form\TypeClientType;
use App\Repository\TypeClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/type/client")
 */
class TypeClientController extends AbstractController
{
    /**
     * @Route("/", name="type_client_index", methods={"GET"})
     */
    public function index(TypeClientRepository $typeClientRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $typeClientRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('type_client/index.html.twig', [
            'type_clients' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="type_client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeClient = new TypeClient();
        $form = $this->createForm(TypeClientType::class, $typeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeClient);
            $entityManager->flush();

            return $this->redirectToRoute('type_client_index');
        }

        return $this->render('type_client/new.html.twig', [
            'type_client' => $typeClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_client_show", methods={"GET"})
     */
    public function show(TypeClient $typeClient): Response
    {
        return $this->render('type_client/show.html.twig', [
            'type_client' => $typeClient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeClient $typeClient): Response
    {
        $form = $this->createForm(TypeClientType::class, $typeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_client_index');
        }

        return $this->render('type_client/edit.html.twig', [
            'type_client' => $typeClient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeClient $typeClient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeClient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_client_index');
    }
}
