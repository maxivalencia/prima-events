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
use Dompdf\Dompdf;
use Dompdf\Options;

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

    /**
     * @Route("/proformat/{ref}", name="proformat_details")
     */
    public function proformatDetails(int $ref, StockRepository $stockRepository, Request $request, PaginatorInterface $paginator)
    {
        $stoks  = $stockRepository->findBy(["reference" => $ref]);
        return $this->render('proformat/details.html.twig', [
            'stocks' => $stoks,
            'reference' => $ref,
        ]);
    }

    /**
     * @Route("/proformat/{ref}/pdf", name="proformat_pdf")
     */
    public function proformatPdf(int $ref, StockRepository $stockRepository, Request $request, PaginatorInterface $paginator)
    {
        $pdfOption = new Options();
        $pdfOption->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOption);
        $stock = new Stock();
        $reference = $ref;
        $logo = $this->getParameter('image').'/LOGOFINAL.GIF';
        $html = $this->renderView('proformat/pdf.html.twig', [
            'stocks' => $stockRepository->findBy(['reference' => $reference]),
            'logo' => $logo,
            'reference' => $reference,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portait');
        $dompdf->render();
        $dompdf->stream("proformat_".$reference.".pdf", [
            "Attachement" => true,
        ]);
        /* $stoks  = $stockRepository->findBy(["reference" => $ref]);
        return $this->render('proformat/details.html.twig', [
            'stocks' => $stoks,
        ]); */
    }
}
