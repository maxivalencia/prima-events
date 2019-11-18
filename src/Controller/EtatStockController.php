<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Mouvement;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\ModeRepository;
use App\Repository\MouvementRepository;
use App\Repository\StockRepository;
use App\Repository\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/etat/stock")
 */
class EtatStockController extends AbstractController
{
    /**
     * @Route("/", name="etat_stock")
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator, ArticleRepository $articleRepository, MouvementRepository $mouvementRepository, ModeRepository $modeRepository): Response
    {
        $articles = $articleRepository->findAll();
        $etat[] = new Stock(); 
        $i = 0;
        $j = 0;
        foreach($articles as $article){
            $art = $article->getId();
            $stockPlus = $stockRepository->findEtatStock($art, 2);
            $st = $stockRepository->findOneBy(['article' => $article]);
            $st->setQuantite(0);
            foreach($stockPlus as $sto){
                if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 1]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 4]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 5])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                    $st->setQuantite($st->getQuantite() - $sto->getQuantite());
                }
                if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 2]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 3])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                    $st->setQuantite($st->getQuantite() + $sto->getQuantite());
                }
            }
            $etat[$i] = $st;
            $i++;
            $j++;
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
    
    
    /**
     * @Route("/quantiterestant", name="quantiterestant", methods={"GET"})
     */
    public function quantiterestant($prod = 1, StockRepository $stocksRepository, Request $request, ArticleRepository $articleRepository, MouvementRepository $mouvementRepository, ModeRepository $modeRepository)
    {
        $i = $request->query->getInt('prod');
        $article = $articleRepository->findOneBy(["id" => $i]);
        $etat = new Stock(); 
        $art = $article->getId();
        $stockPlus = $stocksRepository->findEtatStock($art, 2);
        $st = $stocksRepository->findOneBy(['article' => $article]);
        $st->setQuantite(0);
        foreach($stockPlus as $sto){
            if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 1]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 4]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 5])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                $st->setQuantite($st->getQuantite() - $sto->getQuantite());
            }
            if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 2]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 3])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                $st->setQuantite($st->getQuantite() + $sto->getQuantite());
            }
        }
        $etat = $st;
        return new JsonResponse(['numberAjax' => 200, "dataResponse" => $etat->getQuantite()]);  
    }
}
