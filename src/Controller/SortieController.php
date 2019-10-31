<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Utilisateur;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
//use Symfony\Component\Validator\Constraint\DateTime;
//use PhpOffice\PhpSpreadsheet\Calculation\DateTime;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="sortie")
     */
    public function index(Request $request)
    {
        $stock = new Stock();
        $form = $this->createForm(SortieType::class, $stock);
        $form->handleRequest($request);
        $reference = $form->get('reference')->getData();
        if($reference == ''){
            $daty = new DateTime();
            $results = $daty->format('Y-m-d-H-i-s');
            $krr = explode('-', $results);
            $results = implode("", $krr);
            $stock->setReference($results);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $user = $userRepository->findOneBy(["id" => 1]);
            $stock->setUser($user);
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->redirectToRoute('stock_index');
        }

        return $this->render('stock/new.html.twig', [
            'stock' => $stock,
            'form' => $form->createView(),
        ]);
        /* return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]); */
    }
}
