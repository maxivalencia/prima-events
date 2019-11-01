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
 * @Route("/sortie")
 */
class SortieEffectifController extends AbstractController
{
    /**
     * @Route("/effectif", name="sortie_effectif")
     */
    public function index(StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request, ModeRepository $modeRepository)
    {
        //$stocks = new Stock();
        $mouvement = new Mouvement();
        $mode = new Mode();
        $mouvement = $mouvementRepository->findOneBy(["id" => 1]);
        $mode = $modeRepository->findOneBy(["id" => 1]);
        $pagination = $paginator->paginate(
            $stockRepository->findByGroup($mouvement->getId(), $mode->getId()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('sortie_effectif/index.html.twig', [
            'controller_name' => 'SortieEffectifController',
            'stocks' => $pagination,
        ]);
    }

    /**
     * @Route("/effectif/{ref}", name="sortie_effectif_details", methods={"GET", "POST"})
     */
    public function details(int $ref, StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request)
    {
        $reference = $ref;
        return $this->render('sortie_effectif/details.html.twig',[
            'stocks' => $stockRepository->findBy(["reference" => $reference]),
            'reference' => $reference,
        ]);
    }

    /**
     * @Route("/sortir/{ref}", name="sortie_effectuer", methods={"GET", "POST"})
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
            $sto->setUserSortie($user);
            $modeRepository = $entityManager->getRepository(Mode::class);
            $mode = $modeRepository->findOneBy(["id" => 2]);
            $sto->setMode($mode);
            $sto->setDateSortieEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('sortie_effectif');
    }

    /**
     * @Route("/annuler/{ref}", name="sortie_annuler", methods={"GET", "POST"})
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
            $sto->setUserSortie($user);
            $modeRepository = $entityManager->getRepository(Mode::class);
            $mode = $modeRepository->findOneBy(["id" => 3]);
            $sto->setMode($mode);
            $sto->setDateSortieEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('sortie_effectif');
    }
}
