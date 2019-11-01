<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Utilisateur;
use App\Entity\Mode;
use App\Repository\MouvementRepository;
use App\Repository\StockRepository;
use App\Entity\Mouvement;
use App\Repository\ModeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

/**
 * @Route("/retour")
 */
class RetourController extends AbstractController
{
    /**
     * @Route("/effectif", name="retour_effectif")
     */
    public function index(StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request, ModeRepository $modeRepository)
    {
        //$stocks = new Stock();
        $mouvement = new Mouvement();
        $mode = new Mode();
        $mouvement = $mouvementRepository->findOneBy(["id" => 1]);
        $mode = $modeRepository->findOneBy(["id" => 2]);
        $pagination = $paginator->paginate(
            $stockRepository->findByGroup($mouvement->getId(), $mode->getId()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('retour/index.html.twig', [
            'controller_name' => 'RetourEffectifController',
            'stocks' => $pagination,
        ]);
    }

    /**
     * @Route("/effectif/{ref}", name="retour_effectif_details", methods={"GET", "POST"})
     */
    public function details(int $ref, StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request)
    {
        $reference = $ref;
        return $this->render('retour/details.html.twig',[
            'stocks' => $stockRepository->findBy(["reference" => $reference]),
            'reference' => $reference,
        ]);
    }

    /**
     * @Route("/sortir/{ref}", name="retour_effectuer", methods={"GET", "POST"})
     */
    public function sortir(int $ref, StockRepository $stockRepository)
    {
        //il faut ajouter un repository pour ajouter un utilisateur dans la class
        $reference = $ref; 
        $stocks[] = new Stock();
        $stocks = $stockRepository->findBy(['reference' => $reference]);
        $entityManager = $this->getDoctrine()->getManager();
        foreach($stocks as $sto){
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $user = $userRepository->findOneBy(["id" => 1]);
            $sto->setUserRetour($user);
            $mouvementRepository = $entityManager->getRepository(Mouvement::class);
            $mouvement = $mouvementRepository->findOneBy(["id" => 3]);
            $sto->setMouvement($mouvement);
            $sto->setDateRetourEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('retour_effectif');
    }

    /**
     * @Route("/annuler/{ref}", name="retour_annuler", methods={"GET", "POST"})
     */
    public function annuler(int $ref, StockRepository $stockRepository)
    {
        //il faut ajouter un repository pour ajouter un utilisateur dans la class
        $reference = $ref; 
        $stocks[] = new Stock();
        $stocks = $stockRepository->findBy(['reference' => $reference]);
        $entityManager = $this->getDoctrine()->getManager();
        foreach($stocks as $sto){
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $user = $userRepository->findOneBy(["id" => 1]);
            $sto->setUserRetour($user);
            $mouvementRepository = $entityManager->getRepository(Mouvement::class);
            $mouvement = $mouvementRepository->findOneBy(["id" => 3]);
            $sto->setMouvement($mouvement);
            $sto->setDateRetourEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('retour_effectif');
    }
}
