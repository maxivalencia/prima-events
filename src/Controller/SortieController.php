<?php

namespace App\Controller;

use App\Entity\Mode;
use App\Entity\Mouvement;
use App\Entity\Stock;
use App\Entity\Utilisateur;
use App\Entity\Role;
use App\Entity\Transport;
use App\Form\SortieType;
use App\Form\TransType;
use App\Form\StockType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
//use Symfony\Component\Validator\Constraint\DateTime;
//use PhpOffice\PhpSpreadsheet\Calculation\DateTime;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     */
    public function index(Request $request, StockRepository $stockRepository): Response
    {
        //il faut ajouter un repository pour ajouter un utilisateur dans la class
        $stock = new Stock();
        $form = $this->createForm(SortieType::class, $stock);
        $form->handleRequest($request);
        $reference = $form->get('reference')->getData();
        if($reference == ''){
            $daty = new DateTime();
            $results = $daty->format('Y-m-d-H-i-s');
            $krr = explode('-', $results);
            $results = implode("", $krr);
            $stock->setReference($results);
            $stock->setDateCommande(new DateTime());
            $stock->setDateSortiePrevue($form->get('dateSortiePrevue')->getData());
            $stock->setDateSortieEffectif($form->get('dateRetourPrevu')->getData());
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $user = $userRepository->findOneBy(["id" => 1]);
            $stock->setUser($user);
            $stock->setDateCommande(new DateTime());
            $mouvementRepository = $entityManager->getRepository(Mouvement::class);
            $mouvement = $mouvementRepository->findOneBy(["id" => 1]);
            $stock->setMouvement($mouvement);
            $modeRepository = $entityManager->getRepository(Mode::class);
            $mode = $modeRepository->findOneBy(["id" => 1]);
            $stock->setMode($mode);
            $entityManager->persist($stock);
            $entityManager->flush();

            //return $this->redirectToRoute('stock_index');
        }
        $stocks = $stockRepository->findBy(["reference" => $reference]);
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
            'form' => $form->createView(),
            'stocks' => $stocks,
            'reference' => $reference,
        ]);
    }

    /**
     * @Route("/{id}/commandeedit", name="commande_edit", methods={"GET","POST"})
     */
    public function commandeEdit(int $id, Request $request, Stock $stock, StockRepository $stockRepository): Response
    {
        $identifiantProduit = $id;
        $stock = new Stock();
        $stock = $stockRepository->findOneBy(["id" => $identifiantProduit]);
        $form = $this->createForm(SortieType::class, $stock);
        $form->handleRequest($request);            
        $reference = $form->get('reference')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $stocks = $stockRepository->findBy(["reference" => $reference]);
            return $this->render('sortie/index.html.twig', [
                'controller_name' => 'SortieController',
                'form' => $form->createView(),
                'stocks' => $stocks,
                'reference' => $reference,
            ]);

            //return $this->redirectToRoute('stock_index');
        }

        return $this->render('sortie/edition.html.twig', [
            'stock' => $stock,
            'form' => $form->createView(),
        ]);
    }
}
