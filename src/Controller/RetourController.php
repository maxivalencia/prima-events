<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Utilisateur;
use App\Entity\Mode;
use App\Entity\RetourArticle;
use App\Repository\MouvementRepository;
use App\Repository\StockRepository;
use App\Entity\Mouvement;
use App\Entity\Retour;
use App\Repository\ModeRepository;
use App\Repository\RetourArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RetourArticleType;
use App\Form\RetourType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

/**
 * @Route("/retour")
 */
class RetourController extends AbstractController
{
    /**
     * @Route("/effectif", name="retour_effectif")
     */
    public function index(StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request, ModeRepository $modeRepository, RetourArticleRepository $retourArticleRepository)
    {
        $stock[] = new Stock();
        $retour[] = new RetourArticle();
        $retours = $retourArticleRepository->findAll();
        $i = 0;
        $j = 0;
        foreach($retours as $ret){
            if($ret->getReste() != 0){
                $retour[$i] = $ret;
                $i++;
            }
        }
        $mouvement = new Mouvement();
        $mode = new Mode();
        $mouvement = $mouvementRepository->findOneBy(["id" => 1]);
        $mode = $modeRepository->findOneBy(["id" => 2]);
        //$stocks = $stockRepository->findByGroup($mouvement->getId(), $mode->getId());
        
        foreach($retour as $ret){
            /* foreach($stocks as $sto){
                $valeur1 = $sto->getReference();
                $valeur2 = $ret->getReference();
                if($valeur1->strcmp($valeur2)){
                    $stock[$j] = $sto;
                    $j++;
                }
            } */
            $stock = $stockRepository->findRetour($ret->getReference());
        }
        $pagination = $paginator->paginate(
            $stock,//$stockRepository->findByGroup($mouvement->getId(), $mode->getId()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('retour/index.html.twig', [
            'controller_name' => 'RetourEffectifController',
            'stocks' => $pagination,
        ]);
    }

    /**
     * @Route("/effectif/{ref}", name="retour_effectif_details", methods={"GET", "POST"})
     */
    public function details(int $ref, RetourArticleRepository $retourArticleRepository, StockRepository $stockRepository, MouvementRepository $mouvementRepository, PaginatorInterface $paginator, Request $request)
    {
        $reference = $ref;
        return $this->render('retour/details.html.twig',[
            'stocks' => $retourArticleRepository->findBy(["reference" => $reference]),
            'reference' => $reference,
        ]);
    }

    /**
     * @Route("/sortir/{ref}", name="retour_effectuer", methods={"GET", "POST"})
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
            $user = $this->getUser();
            $sto->setUserRetour($user);
            $mouvementRepository = $entityManager->getRepository(Mouvement::class);
            $mouvement = $mouvementRepository->findOneBy(["id" => 3]);
            $sto->setMouvement($mouvement);
            $sto->setDateRetourEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('retour_effectif');
    }

    /**
     * @Route("/annuler/{ref}", name="retour_annuler", methods={"GET", "POST"})
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
            $sto->setUserRetour($user);
            $mouvementRepository = $entityManager->getRepository(Mouvement::class);
            $mouvement = $mouvementRepository->findOneBy(["id" => 3]);
            $sto->setMouvement($mouvement);
            $sto->setDateRetourEffectif(new DateTime());
            $entityManager->persist($sto);
        }
        $entityManager->flush();
        return $this->redirectToRoute('retour_effectif');
    }

    /**
     * @Route("/{id}/retouredit", name="retour_edit", methods={"GET","POST"})
     */
    public function retourEdit(int $id, Request $request, RetourArticleRepository $retourArticleRepository): Response
    {
        $identifiantProduit = $id;
        $retourArticle = new RetourArticle();
        $retourArticle = $retourArticleRepository->findOneBy(["id" => $identifiantProduit]);
        $form = $this->createForm(RetourType::class, $retourArticle);
        $form->handleRequest($request);            
        $reference = $form->get('reference')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$retourArticle = new RetourArticle();
            //$retourArticle->setReference($sortieArticle->getRefernce());
            //$retourArticle->setArticle($sortieArticle->getArticle());
            $retourArticle->setQuantitesortie($retourArticle->getQuantiteSortie() - $retourArticle->getQuatiteRetourner());
            $retourArticle->setDateRetour(new DateTime());
            //$retourArticle->setQuatiteRetourner(0);
            //$retourArticle->setCassure(0);
            $retourArticle->setReste($retourArticle->getQuantitesortie() - $retourArticle->getQuatiteRetourner());
            $retourArticle->setPrix($retourArticle->getCassure() * $retourArticle->getArticle()->getPrixCasse());
            $entityManager->persist($retourArticle);
            $entityManager->flush();
            /* return $this->render('sortie_effectif/details.html.twig', [
                //'controller_name' => 'SortieController',
                //'form' => $form->createView(),
                'stocks' => $sortieArticles,
                'reference' => $reference,
            ]); */

            return $this->redirectToRoute('retour_effectif_details', [
                'ref' => $reference,
            ]);
        }
        return $this->render('retour/edition.html.twig', [
            'controller_name' => 'SortieController',
            'form' => $form->createView(),
            'stocks' => $retourArticle,
            'reference' => $reference,
        ]);
    }
}
