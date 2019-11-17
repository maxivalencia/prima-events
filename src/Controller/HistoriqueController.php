<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

/**
 * @Route("/historique")
 */
class HistoriqueController extends AbstractController
{
    /**
     * @Route("/", name="historique")
     */
    public function index(StockRepository $stockRepository, Request $request, PaginatorInterface $paginator)
    {
        $pagination = $paginator->paginate(
            $stockRepository->findHistorique(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('historique/index.html.twig', [
            'stocks' => $pagination,
        ]);
    }
    
    /**
     * @Route("/details/{id}", name="historique_details")
     */
    public function historiqueDetails(int $id, StockRepository $stockRepository)
    {
        return $this->render('historique/details.html.twig', [
            'stocks' => $stockRepository->findHistoriqueDetails($id),
        ]);
    }    
    
    /**
     * @Route("/historiqueexcel", name="historique_excel")
     */
    public function historiqueExcel(StockRepository $stockRepository)
    {
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Reference');
        $sheet->setCellValue('B1', 'Date Commande');
        $sheet->setCellValue('C1', 'Client');
        $sheet->setCellValue('D1', 'Date Sortie Prévue');
        $sheet->setCellValue('E1', 'Date Sortie Effectif');
        $sheet->setCellValue('F1', 'Date Retour Prévue');
        $sheet->setCellValue('G1', 'Date Retour Effectif');
        $sheet->setCellValue('H1', 'Nombre Jour');
        $sheet->setCellValue('I1', 'Saisie Commande');
        $sheet->setCellValue('J1', 'Mouvement');
        $sheet->setCellValue('K1', 'Sortie Commande');
        $sheet->setCellValue('L1', 'Retour Commande');
        $sheet->setCellValue('M1', 'Commentaire');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('M1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('B1')->getFont()->setBold(true);
        $sheet->getStyle('C1')->getFont()->setBold(true);
        $sheet->getStyle('D1')->getFont()->setBold(true);
        $sheet->getStyle('E1')->getFont()->setBold(true);
        $sheet->getStyle('F1')->getFont()->setBold(true);
        $sheet->getStyle('G1')->getFont()->setBold(true);
        $sheet->getStyle('H1')->getFont()->setBold(true);
        $sheet->getStyle('I1')->getFont()->setBold(true);
        $sheet->getStyle('J1')->getFont()->setBold(true);
        $sheet->getStyle('K1')->getFont()->setBold(true);
        $sheet->getStyle('L1')->getFont()->setBold(true);
        $sheet->getStyle('M1')->getFont()->setBold(true);
        $sheet->setTitle("Historique");
        $hitoriques = $stockRepository->findHistorique();
        $i = 1;
        foreach($hitoriques as $hist){
            $i++;
            $sheet->setCellValue('A'.$i, $hist->getReference(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValue('B'.$i, $hist->getDateCommande());
            $sheet->setCellValue('C'.$i, $hist->getClient());            
            $sheet->setCellValue('D'.$i, $hist->getDateSortiePrevue());            
            $sheet->setCellValue('E'.$i, $hist->getDateSortieEffectif());            
            $sheet->setCellValue('F'.$i, $hist->getDateRetourPrevu());            
            $sheet->setCellValue('G'.$i, $hist->getDateRetourEffectif());            
            $sheet->setCellValue('H'.$i, $hist->getNbJour());            
            $sheet->setCellValue('I'.$i, $hist->getUser());            
            $sheet->setCellValue('J'.$i, $hist->getMouvement());            
            $sheet->setCellValue('K'.$i, $hist->getUserSortie());            
            $sheet->setCellValue('L'.$i, $hist->getUserRetour());            
            $sheet->setCellValue('M'.$i, $hist->getCommentaire());            
            $sheet->getStyle('A'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        }
        $sheet->getStyle('A')->getNumberFormat();
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = 'historique.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}

