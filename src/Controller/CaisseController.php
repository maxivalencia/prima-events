<?php

namespace App\Controller;

use App\Entity\Indemnite;
use App\Entity\Caution;
use App\Entity\Paye;
use App\Entity\Transport;
use App\Entity\Remise;
use App\Entity\SortieArticle;
use App\Entity\Article;
use App\Form\CautType;
use App\Form\EncaissementType;
use App\Form\IndeType;
use App\Form\TransType;
use App\Form\RemType;
use App\Repository\CautionRepository;
use App\Repository\IndemniteRepository;
use App\Repository\PayementRepository;
use App\Repository\PayeRepository;
use App\Repository\TVARepository;
use App\Repository\TransportRepository;
use App\Repository\RemiseRepository;
use App\Repository\StockRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class CaisseController extends AbstractController
{

    /**
     * @Route("/", name="base")
     */
    public function rediriger(){
        if(!empty($_SESSION['username'])){
            return $this->redirectToRoute('sortie');
        }else{
            return $this->redirectToRoute('app_login');
        }
    }


    /**
     * @Route("/caisse", name="caisse")
     */
    public function index(PayeRepository $payeRepository, PayementRepository $payementRepository)
    {
        $en_caisse = 0;
        $payejournaliere = $payeRepository->findtotal();
        foreach($payejournaliere as $journaliere){
            if($journaliere->getPayement()->getMode() == $payementRepository->findOneBy(["id" => 1])->getMode()){
                $en_caisse += $journaliere->getMontant();
            }else{
                $en_caisse -= $journaliere->getMontant();
            }
        }
        return $this->render('caisse/index.html.twig', [
            'controller_name' => 'CaisseController',
            'caisse' => $en_caisse,
        ]);
    }

    
    /**
     * @Route("/encaissement", name="encaissement", methods={"GET", "POST"})
     */
    public function encaissement(Request $request, StockRepository $stockRepository, TVARepository $tVARepository, PayementRepository $payementRepository, PayeRepository $payeRepository, TransportRepository $transportRepository, RemiseRepository $remiseRepository, CautionRepository $cautionRepository, IndemniteRepository $indemniteRepository)
    {
        $paye = new Paye();
        $trans = new Transport();
        $remi = new Remise();
        $inde = new Indemnite();
        $caut = new Caution();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form1 = $this->createForm(TransType::class, $trans);
        $form2 = $this->createForm(RemType::class, $remi);
        $form3 = $this->createForm(IndeType::class, $inde);
        $form4 = $this->createForm(CautType::class, $caut);
        $form->handleRequest($request);   
        $form1->handleRequest($request);  
        $form2->handleRequest($request);    
        $form3->handleRequest($request);    
        $form4->handleRequest($request);    
        $reference = $form->get('refstock')->getData();
        if($reference == null){
            $reference = $form1->get('reference')->getData();
        }
        if($reference == null){
            $reference = $form2->get('reference')->getData();
        }
        if($reference == null){
            $reference = $form3->get('refence')->getData();
        }
        if($reference == null){
            $reference = $form4->get('reference')->getData();
        }
        if($reference == null){
            $daty = new DateTime();
            $results = $daty->format('Y-m-d-H-i-s');
            $krr = explode('-', $results);
            $results = implode("", $krr);
            $reference = $results;
        }
        $paye->setRefstock($reference);
        $trans->setReference($reference);
        $remi->setReference($reference);
        $inde->setRefence($reference);
        $caut->setReference($reference);
        //$caut->setRefPayement($reference);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $paye->setDatePayement(new DateTime());
            $mode = $payementRepository->findOneBy(["id" => 1]);
            $paye->setPayement($mode);
            $paye->setTVA(true);
            $entityManager->persist($paye);
            $entityManager->flush();
        }
        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trans);
            $entityManager->flush();
        }
        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($remi);
            $entityManager->flush();
        }
        if ($form3->isSubmitted() && $form3->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inde);
            $entityManager->flush();
        }
        if ($form4->isSubmitted() && $form4->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($caut);
            $entityManager->flush();
        }
        $paye = $payeRepository->findOneBy(["refstock" => $reference]);
        $trans = $transportRepository->findOneBy(["reference" => $reference]);        
        $remi = $remiseRepository->findOneBy(["reference" => $reference]);
        $caut = $cautionRepository->findOneBy(["reference" => $reference]);
        
        $payes = $payeRepository->findBy(["refstock" => $reference]);
        $transp = $transportRepository->findOneBy(["reference" => $reference]);
        $remis = $remiseRepository->findOneBy(["reference" => $reference]);

        $ref = $reference;
        $stoks  = $stockRepository->findBy(["reference" => $ref]);
        $indemnites = $indemniteRepository->findBy(["refence" => $ref]);
        $remises = $remiseRepository->findBy(["reference" => $ref]);
        $transports = $transportRepository->findBy(["reference" => $ref]);
        $cautions = $cautionRepository->findBy(["reference" => $ref]);
        $tva = $tVARepository->findOneBy(["id" => 1]);
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
        return $this->render('caisse/encaissement.html.twig', [
            'controller_name' => 'CaisseController',
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'form4' => $form4->createView(),
            'payes' => $payes,
            'transport' => $transport,
            'remise' => $remise,
            'reference' => $reference,
            'caution' => $caution,
            'indemnite' => $indemnite,
            'netapayer' => $netapayer,
            'ttc' => $ttc,
            'total' => $total,
            'tva' => $tvaCollecter,
        ]);
    }

    
    /**
     * @Route("/decaissement", name="decaissement", methods={"GET", "POST"})
     */
    public function decaissement(Request $request, TVARepository $tVARepository, PayementRepository $payementRepository)
    {
        $paye = new Paye();
        $caut = new Caution();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form->handleRequest($request);
        $daty = new DateTime();
        $results = $daty->format('Y-m-d-H-i-s');
        $krr = explode('-', $results);
        $results = implode("", $krr);
        $reference = $results;        
        $paye->setRefPayement($reference);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $paye->setDatePayement(new DateTime());
            //$tVARepository = $entityManager->getRepository(Mouvement::class);
            //$tva = $tVARepository->findOneBy(["id" => 1]);
            //$tVARepository = $entityManager->getRepository(Mouvement::class);
            $mode = $payementRepository->findOneBy(["id" => 2]);
            $paye->setPayement($mode);
            $paye->setTVA(true);
            $entityManager->persist($paye);
            $entityManager->flush();

            //return $this->redirectToRoute('caisse');
        }
        return $this->render('caisse/decaissement.html.twig', [
            'controller_name' => 'CaisseController',
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/refacturation/{ref}", name="refacturation", methods={"GET", "POST"})
     */
    public function refacturation(int $ref, CautionRepository $cautionRepository, Request $request, TVARepository $tVARepository, PayementRepository $payementRepository, PayeRepository $payeRepository, TransportRepository $transportRepository, RemiseRepository $remiseRepository)
    {
        $paye = new Paye();
        $trans = new Transport();
        $remi = new Remise();
        $caut = new Caution();
        $inde = new Indemnite();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form1 = $this->createForm(TransType::class, $trans);
        $form2 = $this->createForm(RemType::class, $remi);
        $form3 = $this->createForm(IndeType::class, $inde);
        $form4 = $this->createForm(CautType::class, $caut);
        $form->handleRequest($request);   
        $form1->handleRequest($request);  
        $form2->handleRequest($request);    
        $form3->handleRequest($request);    
        $form4->handleRequest($request);    
        $reference = $ref;
        if($reference == null){
            $reference = $form1->get('reference')->getData();
        }
        if($reference == null){
            $reference = $form2->get('reference')->getData();
        }
        if($reference == null){
            $daty = new DateTime();
            $results = $daty->format('Y-m-d-H-i-s');
            $krr = explode('-', $results);
            $results = implode("", $krr);
            $reference = $results;
        }
        $paye->setRefstock($reference);
        $trans->setReference($reference);
        $remi->setReference($reference);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $paye->setDatePayement(new DateTime());
            $mode = $payementRepository->findOneBy(["id" => 1]);
            $paye->setPayement($mode);
            $paye->setTVA(true);
            $entityManager->persist($paye);
            $entityManager->flush();
        }
        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trans);
            $entityManager->flush();
        }
        if ($form2->isSubmitted() && $form2->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($remi);
            $entityManager->flush();
        }
        $paye = $payeRepository->findOneBy(["refstock" => $reference]);
        $trans = $transportRepository->findOneBy(["reference" => $reference]);        
        $remi = $remiseRepository->findOneBy(["reference" => $reference]);
        
        $payes = $payeRepository->findBy(["refstock" => $reference]);
        $transp = $transportRepository->findOneBy(["reference" => $reference]);
        $remis = $remiseRepository->findOneBy(["reference" => $reference]);
        return $this->render('caisse/encaissement.html.twig', [
            'controller_name' => 'CaisseController',
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'form4' => $form4->createView(),
            'payes' => $payes,
            'transport' => $transp,
            'remise' => $remis,
            'reference' => $reference,
        ]);
    }

    

    
    /**
     * @Route("/caisse/encaissement/terminer/{ref}", name="encaissement_terminer")
     */
    public function encaissementTerminer(string $ref, StockRepository $stockRepository, ArticleRepository $articleRepository)
    {
        $reference = $ref;
        $stocks = $stockRepository->findBy(["reference" => $reference]);
        $entityManager = $this->getDoctrine()->getManager();        
        foreach($stocks as $sto){
            $sortie = new SortieArticle();
            $article = new Article();
            $article = $sto->getArticle();
            $sortie->setRefernce($reference);
            $sortie->setArticle($article);
            $sortie->setQuantiteCommander($sto->getQuantite());
            $sortie->setDate(new DateTime());
            $sortie->setQuantiteSortie(0);
            $sortie->setReste($sortie->getQuantiteCommander() - $sortie->getQuantiteSortie());
            $entityManager->persist($sortie);
        }
        $entityManager->flush();
        return $this->redirectToRoute('caisse');
    }
}
