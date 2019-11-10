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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
            $user = $userRepository->findOneBy(["id" => 1]);
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
}
