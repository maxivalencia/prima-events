<?php

namespace App\Controller;

use App\Entity\Mode;
use App\Entity\Mouvement;
use App\Entity\Stock;
use App\Entity\Utilisateur;
use App\Form\EntrerType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class EntrerController extends AbstractController
{
    /**
     * @Route("/entrer", name="entrer")
     */
    public function index(Request $request, StockRepository $stockRepository)
    {
        //il faut ajouter un repository pour ajouter un utilisateur dans la class
        $stock = new Stock();
        $form = $this->createForm(EntrerType::class, $stock);
        $form->handleRequest($request);
        $reference = $form->get('reference')->getData();
        if($reference == ''){
            $daty = new DateTime();
            $results = $daty->format('Y-m-d-H-i-s');
            $krr = explode('-', $results);
            $results = implode("", $krr);
            $stock->setReference($results);
            $stock->setDateCommande(new DateTime());
            //$stock->setDateSortiePrevue($form->get('dateSortiePrevue')->getData());
            //$stock->setDateSortieEffectif($form->get('dateRetourPrevu')->getData());
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $user = $userRepository->findOneBy(["id" => 1]);
            $stock->setUser($user);
            $stock->setDateCommande(new DateTime());
            $mouvementRepository = $entityManager->getRepository(Mouvement::class);
            $mouvement = $mouvementRepository->findOneBy(["id" => 2]);
            $stock->setMouvement($mouvement);
            $modeRepository = $entityManager->getRepository(Mode::class);
            $mode = $modeRepository->findOneBy(["id" => 2]);
            $stock->setMode($mode);
            $stock->setClient(null);
            $entityManager->persist($stock);
            $entityManager->flush();

            //return $this->redirectToRoute('stock_index');
        }


        $stocks = $stockRepository->findBy(["reference" => $reference]);
        return $this->render('entrer/index.html.twig', [
            'controller_name' => 'EntrerController',
            'form' => $form->createView(),
            'stocks' => $stocks,
        ]);
    }
}
