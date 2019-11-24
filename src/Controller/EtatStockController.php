<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\Mouvement;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\ModeRepository;
use App\Repository\MouvementRepository;
use App\Repository\StockRepository;
use App\Repository\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/etat/stock")
 */
class EtatStockController extends AbstractController
{
    /**
     * @Route("/", name="etat_stock")
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator, ArticleRepository $articleRepository, MouvementRepository $mouvementRepository, ModeRepository $modeRepository): Response
    {
        $articles = $articleRepository->findAll();
        $etat[] = new Stock(); 
        $i = 0;
        $j = 0;
        foreach($articles as $article){
            $art = $article->getId();
            $stockPlus = $stockRepository->findEtatStock($art, 2);
            $st = $stockRepository->findOneBy(['article' => $article]);
            $st->setQuantite(0);
            foreach($stockPlus as $sto){
                if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 1]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 4]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 5])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                    $st->setQuantite($st->getQuantite() - $sto->getQuantite());
                }
                if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 2]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 3])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                    $st->setQuantite($st->getQuantite() + $sto->getQuantite());
                }
            }
            $etat[$i] = $st;
            $i++;
            $j++;
        }
        
        $pagination = $paginator->paginate(
            $etat, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        return $this->render('etat_stock/index.html.twig', [
            'controller_name' => 'EtatStockController',
            'stocks' => $pagination,
        ]);
    }

    /**
     * @Route("/etat_stock_pdf", name="etat_stock_PDF")
     */
    public function etatPDF(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator, ArticleRepository $articleRepository, MouvementRepository $mouvementRepository, ModeRepository $modeRepository)
    {
        $spreadsheet = new Spreadsheet();
        $articles = $articleRepository->findAll();
        $etat[] = new Stock(); 
        $i = 0;
        $j = 0;
        foreach($articles as $article){
            $art = $article->getId();
            $stockPlus = $stockRepository->findEtatStock($art, 2);
            $st = $stockRepository->findOneBy(['article' => $article]);
            $st->setQuantite(0);
            foreach($stockPlus as $sto){
                if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 1]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 4]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 5])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                    $st->setQuantite($st->getQuantite() - $sto->getQuantite());
                }
                if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 2]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 3])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                    $st->setQuantite($st->getQuantite() + $sto->getQuantite());
                }
            }
            $etat[$i] = $st;
            $i++;
            $j++;
        }
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Article');
        $sheet->setCellValue('B1', 'Quantité');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $i = 1;
        foreach($etat as $et){  
            $i++;          
            $sheet->setCellValue('A'.$i, $et->getArticle());
            $sheet->setCellValue('B'.$i, $et->getQuantite()); 
        }
        $sheet->getStyle('B')->getNumberFormat();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = 'etat_de_stock.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
    
    
    /**
     * @Route("/quantiterestant", name="quantiterestant", methods={"GET"})
     */
    public function quantiterestant($prod = 1, StockRepository $stocksRepository, Request $request, ArticleRepository $articleRepository, MouvementRepository $mouvementRepository, ModeRepository $modeRepository)
    {
        $i = $request->query->getInt('prod');
        $article = $articleRepository->findOneBy(["id" => $i]);
        $etat = new Stock(); 
        $art = $article->getId();
        $stockPlus = $stocksRepository->findEtatStock($art, 2);
        $st = $stocksRepository->findOneBy(['article' => $article]);
        $st->setQuantite(0);
        foreach($stockPlus as $sto){
            if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 1]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 4]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 5])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                $st->setQuantite($st->getQuantite() - $sto->getQuantite());
            }
            if(($sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 2]) || $sto->getMouvement() == $mouvementRepository->findOneBy(["id" => 3])) && $sto->getMode() == $modeRepository->findOneBy(["id" => 2])){
                $st->setQuantite($st->getQuantite() + $sto->getQuantite());
            }
        }
        $etat = $st;
        return new JsonResponse(['numberAjax' => 200, "dataResponse" => $etat->getQuantite()]);  
    }
}
