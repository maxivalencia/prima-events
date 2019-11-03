<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Mouvement;
use App\Repository\ArticleRepository;
use App\Repository\MouvementRepository;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;

/**
 * @Route("/etat/stock")
 */
class EtatStockController extends AbstractController
{
    /**
     * @Route("/", name="etat_stock")
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator, ArticleRepository $articleRepository, MouvementRepository $mouvementRepository): Response
    {
        $articles[] = $articleRepository->findAll();
        $etat[] = new Stock(); 
        $i = 0;
        foreach($articles as $article){
            $art = $article[0]->getId();
            $stockPlus = $stockRepository->findEtatStock($art, 2);
            $st = $stockRepository->findOneBy(['article' => $article]);
            $st->setQuantite(0);
            foreach($stockPlus as $sto){
                if($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 1]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 4]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 5])){
                    $st->setQuantite($st->getQuantite() - $sto->getQuantite());
                }
                if($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 2])/*  || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 3]) */){
                    $st->setQuantite($st->getQuantite() + $sto->getQuantite());
                }
            }
            $etat[$i] = $st;
            $i++;
        }
        
        $pagination = $paginator->paginate(
            $etat, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        return $this->render('etat_stock/index.html.twig', [
            'controller_name' => 'EtatStockController',
            'stocks' => $pagination,
        ]);
    }
}
