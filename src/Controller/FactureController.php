<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Entity\Paye;
use App\Entity\Transport;
use App\Entity\Remise;
use App\Form\TransportType;
use App\Form\EncaissementType;
use App\Form\DecaissementType;
use App\Form\TransType;
use App\Form\RemType;
use App\Repository\CautionRepository;
use App\Repository\IndemniteRepository;
use App\Repository\StockRepository;
use App\Repository\PayementRepository;
use App\Repository\PayeRepository;
use App\Repository\TVARepository;
use App\Repository\TransportRepository;
use App\Repository\RemiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use DateTime;

class FactureController extends AbstractController
{
    /**
     * @Route("/facture", name="facture")
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator, PayeRepository $payeRepository)
    {
        /* $facturepayers = $payeRepository->findGroup();
        $facture[] = new Stock();
        $i = 0;
        foreach($facturepayers as $fact){
            //$facture = $stockRepository->findBy(["reference" => $fact->getRefstock()]);
            //if($stockRepository->findOneBy(["reference" => $fact->getRefstock()])){ 
                //$facture[$i] = $stockRepository->findBy(["reference" => $fact->getRefstock()]);
                $facture[$i] = $stockRepository->findOneBy(["reference" => "20191103090930"]);
                $i = $fact->getRefstock();
            //}
        } */
        $pagination = $paginator->paginate(
            $stockRepository->findFacture(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('facture/index.html.twig', [
            'stocks' => $pagination,
        ]);
    }

    /**
     * @Route("/facture/{ref}", name="facture_details")
     */
    public function factureDetails(int $ref, TVARepository $tvaRepository, StockRepository $stockRepository, IndemniteRepository $indemniteRepository, RemiseRepository $remiseRepository, TransportRepository $transportRepository, CautionRepository $cautionRepository, Request $request, PaginatorInterface $paginator)
    {
        $stoks  = $stockRepository->findBy(["reference" => $ref]);
        $indemnites = $indemniteRepository->findBy(["refence" => $ref]);
        $remises = $remiseRepository->findBy(["reference" => $ref]);
        $transports = $transportRepository->findBy(["reference" => $ref]);
        $cautions = $cautionRepository->findBy(["reference" => $ref]);
        $tva = $tvaRepository->findOneBy(["id" => 1]);
        $indemnite = 0;
        $remise = 0;
        $transport = 0;
        $caution = 0;
        $total = 0;
        foreach($indemnites as $inde){
            $indemnite += $inde->getPrix();
        }
        foreach($remises as $remi){
            $remise += $remi->getTaux();
        }
        foreach($transports as $trans){
            $transport += $trans->getPrix();
        }
        foreach($cautions as $caut){
            $caution += $caut->getPrix();
        }
        foreach($stoks as $sto){
            $total = $total + (($sto->getArticle()->getPrixUnitaire() * $sto->getQuantite()) - $sto->getRemise());
        }
        $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = $tvaCollecter + $total;
        return $this->render('facture/details.html.twig', [
            'stocks' => $stoks,
            'reference' => $ref,
            'indemnite' => $indemnite,
            'remise' => $remise,
            'transport' => $transport,
            'caution' => $caution,
            'total' => $total,
            'tvaCollecter' => $tvaCollecter,
            'ttc' => $ttc,
            'netapayer' => $netapayer,
        ]);
    }

    /**
     * @Route("/facture/{ref}/pdf", name="facture_pdf")
     */
    public function facturePdf(int $ref, TVARepository $tvaRepository, StockRepository $stockRepository, IndemniteRepository $indemniteRepository, RemiseRepository $remiseRepository, TransportRepository $transportRepository, CautionRepository $cautionRepository, Request $request, PaginatorInterface $paginator)
    {
        $pdfOption = new Options();
        $pdfOption->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOption);
        $stock = new Stock();
        $reference = $ref;
        $indemnites = $indemniteRepository->findBy(["refence" => $ref]);
        $remises = $remiseRepository->findBy(["reference" => $ref]);
        $transports = $transportRepository->findBy(["reference" => $ref]);
        $cautions = $cautionRepository->findBy(["reference" => $ref]);
        $stoks  = $stockRepository->findBy(["reference" => $ref]);
        $tva = $tvaRepository->findOneBy(["id" => 1]);
        $indemnite = 0;
        $remise = 0;
        $transport = 0;
        $caution = 0;
        $total = 0;
        foreach($indemnites as $inde){
            $indemnite += $inde->getPrix();
        }
        foreach($remises as $remi){
            $remise += $remi->getTaux();
        }
        foreach($transports as $trans){
            $transport += $trans->getPrix();
        }
        foreach($cautions as $caut){
            $caution += $caut->getPrix();
        }
        foreach($stoks as $sto){
            $total = $total + (($sto->getArticle()->getPrixUnitaire() * $sto->getQuantite()) - $sto->getRemise());
        }
        $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = $tvaCollecter + $total;
        //$trans = $transportRepository->findOneBy(["reference" => $reference]);        
        //$remi = $remiseRepository->findOneBy(["reference" => $reference]);
        $logo = $this->getParameter('image').'/LOGOFINAL.GIF';
        $html = $this->renderView('facture/pdf.html.twig', [
            'stocks' => $stockRepository->findBy(['reference' => $reference]),
            'logo' => $logo,
            'reference' => $reference,
            'indemnite' => $indemnite,
            'remise' => $remise,
            'transport' => $transport,
            'caution' => $caution,
            'total' => $total,
            'tvaCollecter' => $tvaCollecter,
            'ttc' => $ttc,
            'netapayer' => $netapayer,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portait');
        $dompdf->render();
        $dompdf->stream("facture_".$reference.".pdf", [
            "Attachement" => true,
        ]);
        /* $stoks  = $stockRepository->findBy(["reference" => $ref]);
        return $this->render('facture/details.html.twig', [
            'stocks' => $stoks,
        ]); */
    }
}
