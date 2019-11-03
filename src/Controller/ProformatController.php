<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

class ProformatController extends AbstractController
{
    /**
     * @Route("/proformat", name="proformat")
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $stockRepository->findProformat(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('proformat/index.html.twig', [
            'stocks' => $pagination,
        ]);
    }
}
