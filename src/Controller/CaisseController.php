<?php

namespace App\Controller;

use App\Entity\Paye;
use App\Entity\Transport;
use App\Entity\Remise;
use App\Form\TransportType;
use App\Form\EncaissementType;
use App\Form\DecaissementType;
use App\Form\TransType;
use App\Form\RemType;
use App\Repository\PayementRepository;
use App\Repository\PayeRepository;
use App\Repository\TVARepository;
use App\Repository\TransportRepository;
use App\Repository\RemiseRepository;
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
    public function index()
    {
        return $this->render('caisse/index.html.twig', [
            'controller_name' => 'CaisseController',
        ]);
    }

    
    /**
     * @Route("/encaissement", name="encaissement", methods={"GET", "POST"})
     */
    public function encaissement(Request $request, TVARepository $tVARepository, PayementRepository $payementRepository, PayeRepository $payeRepository, TransportRepository $transportRepository, RemiseRepository $remiseRepository)
    {
        $paye = new Paye();
        $trans = new Transport();
        $remi = new Remise();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form1 = $this->createForm(TransType::class, $trans);
        $form2 = $this->createForm(RemType::class, $remi);
        $form->handleRequest($request);   
        $form1->handleRequest($request);  
        $form2->handleRequest($request);    
        $reference = $form->get('refstock')->getData();
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
            'payes' => $payes,
            'transport' => $transp,
            'remise' => $remis,
            'reference' => $reference,
        ]);
    }

    
    /**
     * @Route("/decaissement", name="decaissement", methods={"GET", "POST"})
     */
    public function decaissement(Request $request, TVARepository $tVARepository, PayementRepository $payementRepository)
    {
        $paye = new Paye();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form->handleRequest($request);
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
    public function refacturation(int $ref, Request $request, TVARepository $tVARepository, PayementRepository $payementRepository, PayeRepository $payeRepository, TransportRepository $transportRepository, RemiseRepository $remiseRepository)
    {
        $paye = new Paye();
        $trans = new Transport();
        $remi = new Remise();
        $form = $this->createForm(EncaissementType::class, $paye);
        $form1 = $this->createForm(TransType::class, $trans);
        $form2 = $this->createForm(RemType::class, $remi);
        $form->handleRequest($request);   
        $form1->handleRequest($request);  
        $form2->handleRequest($request);    
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
            'payes' => $payes,
            'transport' => $transp,
            'remise' => $remis,
            'reference' => $reference,
        ]);
    }
}
