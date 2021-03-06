<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Utilisateur;
use App\Entity\Mode;
use App\Entity\SortieArticle;
use App\Entity\RetourArticle;
use App\Form\SortieArticleEditionType;
use App\Repository\MouvementRepository;
use App\Repository\StockRepository;
use App\Entity\Mouvement;
use App\Repository\ModeRepository;
use App\Repository\SortieArticleRepository;
use App\Repository\UserRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;
use DateTime;

/**
 * @Route("/sortie")
 */
class SortieEffectifController extends AbstractController
{
    /**
     * @Route("/effectif", name="sortie_effectif")
     */
    public function index(StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request, ModeRepository $modeRepository)
    {
        //$stocks = new Stock();
        $mouvement = new Mouvement();
        $mode = new Mode();
        $mouvement = $mouvementRepository->findOneBy(["id" => 1]);
        $mode = $modeRepository->findOneBy(["id" => 1]);
        $pagination = $paginator->paginate(
            $stockRepository->findByGroup($mouvement->getId(), $mode->getId()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('sortie_effectif/index.html.twig', [
            'controller_name' => 'SortieEffectifController',
            'stocks' => $pagination,
        ]);
    }

    /**
     * @Route("/effectif/{ref}", name="sortie_effectif_details", methods={"GET", "POST"})
     */
    public function details(int $ref, SortieArticleRepository $sortieArticleRepository, StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request)
    {
        $reference = $ref;
        return $this->render('sortie_effectif/details.html.twig',[
            'stocks' => $sortieArticleRepository->findBy(["refernce" => $reference]),
            'reference' => $reference,
        ]);
    }

    /**
     * @Route("/sortir/{ref}", name="sortie_effectuer", methods={"GET", "POST"})
     */
    public function sortir(int $ref, StockRepository $stockRepository)
    {
        //il faut ajouter un repository pour ajouter un utilisateur dans la class
        $reference = $ref; 
        $stocks[] = new Stock();
        $stocks = $stockRepository->findBy(['reference' => $reference]);
        $entityManager = $this->getDoctrine()->getManager();
        foreach($stocks as $sto){
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            //$user = $userRepository->findOneBy(["id" => 1]);
            //$user = $this->getUser();
            $user = $userRepository->findOneBy(["id" => $this->getUser()->getId()]);
            $sto->setUserSortie($user);
            $modeRepository = $entityManager->getRepository(Mode::class);
            $mode = $modeRepository->findOneBy(["id" => 2]);
            $sto->setMode($mode);
            $sto->setDateSortieEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('sortie_effectif');
    }

    /**
     * @Route("/annuler/{ref}", name="sortie_annuler", methods={"GET", "POST"})
     */
    public function annuler(int $ref, StockRepository $stockRepository)
    {
        //il faut ajouter un repository pour ajouter un utilisateur dans la class
        $reference = $ref; 
        $stocks[] = new Stock();
        $stocks = $stockRepository->findBy(['reference' => $reference]);
        $entityManager = $this->getDoctrine()->getManager();
        foreach($stocks as $sto){
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $user = $userRepository->findOneBy(["id" => 1]);
            $sto->setUserSortie($user);
            $modeRepository = $entityManager->getRepository(Mode::class);
            $mode = $modeRepository->findOneBy(["id" => 3]);
            $sto->setMode($mode);
            $sto->setDateSortieEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('sortie_effectif');
    }

    /**
     * @Route("/{id}/sortieedit", name="sortie_edit", methods={"GET","POST"})
     */
    public function SortieEdit(int $id, Request $request, SortieArticle $sortieArticle, SortieArticleRepository $sortieArticleRepository): Response
    {
        $identifiantProduit = $id;
        $sortieArticle = new SortieArticle();
        $sortieArticle = $sortieArticleRepository->findOneBy(["id" => $identifiantProduit]);
        $form = $this->createForm(SortieArticleEditionType::class, $sortieArticle);
        $form->handleRequest($request);            
        $reference = $form->get('refernce')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $sortieArticle->setDate(new DateTime());
            $sortieArticle->setReste($sortieArticle->getQuantiteCommander() - $sortieArticle->getQuantiteSortie());
            $sortieArticle->setQuantiteSortie($sortieArticle->getQuantiteSortie());
            //$sortieArticles = $sortieArticleRepository->findBy(["refernce" => $reference]);
            $entityManager->persist($sortieArticle);
            $sortieArticle2 = new SortieArticle();
            $sortieArticle2->setArticle($sortieArticle->getArticle());
            $sortieArticle2->setRefernce($sortieArticle->getRefernce());
            $sortieArticle2->setQuantiteCommander($sortieArticle->getReste());
            $sortieArticle2->setQuantiteSortie(0);
            $sortieArticle2->setDate(new DateTime());
            $sortieArticle2->setReste($sortieArticle2->getQuantiteCommander() - $sortieArticle2->getQuantiteSortie());
            //$entityManager->detach($sortieArticle2);
            $retourArticle = new RetourArticle();
            $retourArticle->setReference($sortieArticle->getRefernce());
            $retourArticle->setArticle($sortieArticle->getArticle());
            $retourArticle->setQuantitesortie($sortieArticle->getQuantiteSortie());
            $retourArticle->setDateRetour(new DateTime());
            $retourArticle->setQuatiteRetourner(0);
            $retourArticle->setCassure(0);
            $retourArticle->setReste($retourArticle->getQuantitesortie() - $retourArticle->getQuatiteRetourner());
            $retourArticle->setPrix($retourArticle->getCassure() * $retourArticle->getArticle()->getPrixCasse());
            $entityManager->persist($sortieArticle2);
            $entityManager->persist($retourArticle);
            $entityManager->flush();
            /* return $this->render('sortie_effectif/details.html.twig', [
                //'controller_name' => 'SortieController',
                //'form' => $form->createView(),
                'stocks' => $sortieArticles,
                'reference' => $reference,
            ]); */

            return $this->redirectToRoute('sortie_effectif_details', [
                'ref' => $reference,
            ]);
        }

        return $this->render('sortie_effectif/edition.html.twig', [
            //'stock' => $sortieArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/imprimer/{ref}", name="sortie_imprimer", methods={"GET", "POST"})
     */
    public function imprimer(int $ref, UtilisateurRepository $utilisateurRepository, StockRepository $stockRepository, SortieArticleRepository $sortieArticleRepository, UserRepository $userRepository)
    {
        $pdfOption = new Options();
        $pdfOption->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOption);
        //il faut ajouter un repository pour ajouter un utilisateur dans la class
        $reference = $ref; 
        $user = $userRepository->findOneBy(["id" => $this->getUser()->getId()]);
        $responsable = $utilisateurRepository->findOneBy(["id" => $this->getUser()->getId()]);
        $client = $stockRepository->findOneBy(["reference" => $reference])->getClient()->getNom();
        $logo = $this->getParameter('image').'/LOGOFINAL.GIF';
        /* $date_evenement = new Date();
        $date_acquisition = new Date();
        $date_retour_prevue = new Date();
        foreach($sortieArticleRepository->findBy(['refernce' => $reference]) as $sto){            
            $date_evenement = $sto->getDateEvenement();
            $date_acquisition = $sto->getDateSortieEffectif();
            $date_retour_prevue = $sto->getDateRetourPrevu();
        } */
        $html = $this->renderView('sortie_effectif/pdf.html.twig', [
            'stocks' => $sortieArticleRepository->findBy(['refernce' => $reference]),
            'logo' => $logo,
            'reference' => $reference,
            'responsable' => $responsable->getNom(),
            'client' => $client,
            /* 'dateevenement' => $date_evenement,
            'dateacquisition' => $date_acquisition,
            'dateretour' => $date_retour_prevue, */
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portait');
        $dompdf->render();
        $dompdf->stream("bons_de_sortie_".$reference.".pdf", [
            "Attachement" => true,
        ]);
        
        
        
        
        
        return $this->render('sortie_effectif/details.html.twig',[
            'stocks' => $sortieArticleRepository->findBy(["refernce" => $reference]),
            'reference' => $reference,
        ]);
    }
}
