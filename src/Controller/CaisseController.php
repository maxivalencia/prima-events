<?php

namespace App\Controller;

use App\Entity\Paye;
use App\Form\EncaissementType;
use App\Form\DecaissementType;
use App\Repository\PayementRepository;
use App\Repository\TVARepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class CaisseController extends AbstractController
{
    /**
     * @Route("/caisse", name="caisse")
     */
    public function index()
    {
        return $this->render('caisse/index.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }

    
    /**
     * @Route("/encaissement", name="encaissement", methods={"GET", "POST"})
     */
    public function encaissement(Request $request, TVARepository $tVARepository, PayementRepository $payementRepository)
    {
        $paye = new Paye();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $paye->setDatePayement(new DateTime());
            //$tVARepository = $entityManager->getRepository(Mouvement::class);
            //$tva = $tVARepository->findOneBy(["id" => 1]);
            //$tVARepository = $entityManager->getRepository(Mouvement::class);
            $mode = $payementRepository->findOneBy(["id" => 1]);
            $paye->setPayement($mode);
            $paye->setTVA(true);
            $entityManager->persist($paye);
            $entityManager->flush();

            return $this->redirectToRoute('caisse');
        }
        return $this->render('caisse/encaissement.html.twig', [
            'controller_name' => 'CaisseController',
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/decaissement", name="decaissement", methods={"GET", "POST"})
     */
    public function decaissement(Request $request, TVARepository $tVARepository, PayementRepository $payementRepository)
    {
        $paye = new Paye();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $paye->setDatePayement(new DateTime());
            //$tVARepository = $entityManager->getRepository(Mouvement::class);
            //$tva = $tVARepository->findOneBy(["id" => 1]);
            //$tVARepository = $entityManager->getRepository(Mouvement::class);
            $mode = $payementRepository->findOneBy(["id" => 2]);
            $paye->setPayement($mode);
            $paye->setTVA(true);
            $entityManager->persist($paye);
            $entityManager->flush();

            return $this->redirectToRoute('caisse');
        }
        return $this->render('caisse/decaissement.html.twig', [
            'controller_name' => 'CaisseController',
            'form' => $form->createView(),
        ]);
    }
}
