<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/historique")
 */
class HistoriqueController extends AbstractController
{
    /**
     * @Route("/", name="historique")
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $stockRepository->findHistorique(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('historique/index.html.twig', [
            'stocks' => $pagination,
        ]);
    }
    
    /**
     * @Route("/details/{id}", name="historique_details")
     */
    public function historiqueDetails(int $id, StockRepository $stockRepository)
    {
        return $this->render('historique/details.html.twig', [
            'stocks' => $stockRepository->findHistoriqueDetails($id),
        ]);
    }
}
