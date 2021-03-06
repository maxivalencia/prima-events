<?php

namespace App\Controller;

use App\Entity\Client;
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
use App\Repository\TypeClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use DateTime;
use Proxies\__CG__\App\Entity\TypeClient;

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
    public function proformatDetails(int $ref, TypeClientRepository $typeClientRepository, TVARepository $tvaRepository, StockRepository $stockRepository, IndemniteRepository $indemniteRepository, RemiseRepository $remiseRepository, TransportRepository $transportRepository, CautionRepository $cautionRepository, Request $request, PaginatorInterface $paginator)
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
        $client = '';
        $typeclient = new TypeClient();
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
            $client = $sto->getClient();
            $typeclient = $sto->getClient();
        }
        $clientType = $typeClientRepository->findOneBy(["id" => 1]);
        $tvaCollecter = 0;
        if(strcmp($typeclient->getTypeClient(), $clientType->getType()) == 0){
            $tvaCollecter = 0;
        }else{
            $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        }
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = 0;
        if(strcmp($typeclient->getTypeClient(), $clientType->getType()) != 0){
            $ttc = $tvaCollecter + $total;
        }else{
            $ttc = 0;
        }
        return $this->render('proformat/details.html.twig', [
            'stocks' => $stoks,
            'reference' => $ref,
            'indemnite' => $indemnite,
            'remise' => $remise,
            'transport' => $transport,
            'caution' => $caution,
            'total' => $total,
            'tvaCollecter' => $tvaCollecter,
            'ttc' => $ttc,
            'client' => $client,
            'netapayer' => $netapayer,
        ]);
    }

    /**
     * @Route("/proformat/valider/{ref}", name="proformat_Valider")
     */
    public function proformatValider(int $ref, StockRepository $stockRepository, Request $request, PaginatorInterface $paginator)
    {
        $stoks  = $stockRepository->findBy(["reference" => $ref]);        
        $entityManager = $this->getDoctrine()->getManager();
        foreach($stoks as $sto){
            $sto->setDateDeValidationProformat(new DateTime());
            //$sto->set
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('facture');
        /* return $this->render('proformat/details.html.twig', [
            'stocks' => $stoks,
            'reference' => $ref,
        ]); */
    }

    /**
     * @Route("/proformat/{ref}/pdf", name="proformat_pdf")
     */
    public function proformatPdf(int $ref, TypeClientRepository $typeClientRepository, TVARepository $tvaRepository, StockRepository $stockRepository, IndemniteRepository $indemniteRepository, RemiseRepository $remiseRepository, TransportRepository $transportRepository, CautionRepository $cautionRepository, Request $request, PaginatorInterface $paginator)
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
        $client = '';
        $typeclient = new TypeClient();
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
            $client = $sto->getClient()->getNom();
            $typeclient = $sto->getClient();
        }
        /* $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = $tvaCollecter + $total; */
        $clientType = $typeClientRepository->findOneBy(["id" => 1]);
        $tvaCollecter = 0;
        if(strcmp($typeclient->getTypeClient(), $clientType->getType()) == 0){
            $tvaCollecter = 0;
        }else{
            $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        }
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = 0;
        if(strcmp($typeclient->getTypeClient(), $clientType->getType()) != 0){
            $ttc = $tvaCollecter + $total;
        }else{
            $ttc = 0;
        }
        
        //$paye = $payeRepository->findOneBy(["refstock" => $reference]);
        //$trans = $transportRepository->findOneBy(["reference" => $reference]);        
        //$remi = $remiseRepository->findOneBy(["reference" => $reference]);
        
        //$payes = $payeRepository->findBy(["refstock" => $reference]);
        //$transp = $transportRepository->findOneBy(["reference" => $reference]);
        //$remis = $remiseRepository->findOneBy(["reference" => $reference]);

        $logo = $this->getParameter('image').'/LOGOFINAL.GIF';
        $html = $this->renderView('proformat/pdf.html.twig', [
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
            'client' => $client,
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
