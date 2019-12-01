<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Entity\Paye;
use App\Entity\Transport;
use App\Entity\TypeClient;
use App\Entity\Remise;
use App\Form\TransportType;
use App\Form\EncaissementType;
use App\Form\DecaissementType;
use App\Form\TransType;
use App\Form\RemType;
use App\Repository\CautionRepository;
use App\Repository\ClientRepository;
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
use Symfony\Component\Validator\Constraints\Date;

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
    public function factureDetails(int $ref, TypeClientRepository $typeClientRepository, TVARepository $tvaRepository, StockRepository $stockRepository, IndemniteRepository $indemniteRepository, RemiseRepository $remiseRepository, TransportRepository $transportRepository, CautionRepository $cautionRepository, Request $request, PaginatorInterface $paginator)
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
        /* $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = $tvaCollecter + $total; */
        /* $clientType = $typeClientRepository->findOneBy(["id" => 1]);
        $tvaCollecter = 0; */
        
        $clientType = $typeClientRepository->findOneBy(["id" => 1]);
        $clientType2 = $typeClientRepository->findOneBy(["id" => 4]);
        $tvaCollecter = 0;
        if(strcmp($typeclient->getTypeClient(), $clientType->getType()) == 0 || strcmp($typeclient->getTypeClient(), $clientType2->getType()) == 0){
            $tvaCollecter = 0;
        }else{
            $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        }
        /* if(strcmp($typeclient->getTypeClient(), $clientType->getType()) == 0){
            $tvaCollecter = 0;
        }else{
            $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        } */
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = 0;
        if(strcmp($typeclient->getTypeClient(), $clientType->getType()) != 0){
            $ttc = $tvaCollecter + $total;
        }else{
            $ttc = 0;
        }
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
            'client' => $client,
            'netapayer' => $netapayer,
        ]);
    }

    /**
     * @Route("/facture/{ref}/pdf", name="facture_pdf")
     */
    public function facturePdf(int $ref, PayeRepository $payeRepository, TypeClientRepository $typeClientRepository, TVARepository $tvaRepository, StockRepository $stockRepository, IndemniteRepository $indemniteRepository, RemiseRepository $remiseRepository, TransportRepository $transportRepository, CautionRepository $cautionRepository, Request $request, PaginatorInterface $paginator)
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
        $type_client = '';
        $type_client_reference = $typeClientRepository->findOneBy(["id" => 3]);
        $client = '';
        $typeclient = new TypeClient();
        $date_evenement = new Date();
        $date_acquisition = new Date();
        $date_retour_prevue = new Date();
        $paye = 0;
        foreach($payeRepository->findBy(["refstock" => $reference]) as $p){
            $paye += $p->getMontant();
        }
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
            $type_client = $sto->getClient()->getTypeClient();
            $client = $sto->getClient()->getNom();
            $typeclient = $sto->getClient();
            $date_evenement = $sto->getDateEvenement();
            $date_acquisition = $sto->getDateSortieEffectif();
            $date_retour_prevue = $sto->getDateRetourPrevu();
        }
        /* $tvaCollecter = (($total - $caution) * $tva->getTva()) / 100;
        $netapayer = $total + $caution + $transport + $indemnite + $tvaCollecter - $remise;
        $ttc = $tvaCollecter + $total; */
        $clientType = $typeClientRepository->findOneBy(["id" => 1]);
        $clientType2 = $typeClientRepository->findOneBy(["id" => 4]);
        $tvaCollecter = 0;
        if(strcmp($typeclient->getTypeClient(), $clientType->getType()) == 0 || strcmp($typeclient->getTypeClient(), $clientType2->getType()) == 0){
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
            'totallettre' => $this->asLetters($netapayer),
            'payer' => $paye,
            'reste' => $netapayer - $paye,
            'typeclient' => $type_client,
            'typeclientreference' => $type_client_reference->getType(),
            'client' => $client,
            'dateevenement' => $date_evenement,
            'dateacquisition' => $date_acquisition,
            'dateretour' => $date_retour_prevue,
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


    /**
     * @Route("/asLetters", name="asLetters")
     */
    function asLetters($number) {
        //$convert = explode($separateur, $number);
        $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
                         'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');
                          
        $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
                          60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');
                                          
        /* if (isset($convert[1]) && $convert[1] != '') {
          return asLetters($convert[0]).' et '.asLetters($convert[1]);
        } */
        if ($number < 0) return 'moins '.$this->asLetters(-$number);
        if ($number < 17) {
          return $num[17][$number];
        }
        elseif ($number < 20) {
          return 'dix-'.$this->asLetters($number-10);
        }
        elseif ($number < 100) {
          if ($number%10 == 0) {
            return $num[100][$number];
          }
          elseif (substr($number, -1) == 1) {
            if( ((int)($number/10)*10)<70 ){
              return $this->asLetters((int)($number/10)*10).'-et-un';
            }
            elseif ($number == 71) {
              return 'soixante-et-onze';
            }
            elseif ($number == 81) {
              return 'quatre-vingt-un';
            }
            elseif ($number == 91) {
              return 'quatre-vingt-onze';
            }
          }
          elseif ($number < 70) {
            return $this->asLetters($number-$number%10).'-'.$this->asLetters($number%10);
          }
          elseif ($number < 80) {
            return $this->asLetters(60).'-'.$this->asLetters($number%20);
          }
          else {
            return $this->asLetters(80).'-'.$this->asLetters($number%20);
          }
        }
        elseif ($number == 100) {
          return 'cent';
        }
        elseif ($number < 200) {
          return $this->asLetters(100).' '.$this->asLetters($number%100);
        }
        elseif ($number < 1000) {
          return $this->asLetters((int)($number/100)).' '.$this->asLetters(100).($number%100 > 0 ? ' '.$this->asLetters($number%100): '');
        }
        elseif ($number == 1000){
          return 'mille';
        }
        elseif ($number < 2000) {
          return $this->asLetters(1000).' '.$this->asLetters($number%1000).' ';
        }
        elseif ($number < 1000000) {
          return $this->asLetters((int)($number/1000)).' '.$this->asLetters(1000).($number%1000 > 0 ? ' '.$this->asLetters($number%1000): '');
        }
        elseif ($number == 1000000) {
          return 'millions';
        }
        elseif ($number < 2000000) {
          return $this->asLetters(1000000).' '.$this->asLetters($number%1000000);
        }
        elseif ($number < 1000000000) {
          return $this->asLetters((int)($number/1000000)).' '.$this->asLetters(1000000).($number%1000000 > 0 ? ' '.$this->asLetters($number%1000000): '');
        }
      }
    
}
