<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Repository\PayeRepository;
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
    public function historiqueExcel(StockRepository $stockRepository, PayeRepository $payeRepository)
    {
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Reference');
        $sheet->setCellValue('B1', 'Date Commande');
        $sheet->setCellValue('C1', 'Client');
        $sheet->setCellValue('D1', 'Article');
        $sheet->setCellValue('E1', 'Quantité');
        $sheet->setCellValue('F1', 'Date Sortie Prévue');
        $sheet->setCellValue('G1', 'Date Sortie Effectif');
        $sheet->setCellValue('H1', 'Date Retour Prévue');
        $sheet->setCellValue('I1', 'Date Retour Effectif');
        $sheet->setCellValue('J1', 'Nombre Jour');
        $sheet->setCellValue('K1', 'Saisie Commande');
        $sheet->setCellValue('L1', 'Mouvement');
        $sheet->setCellValue('M1', 'Sortie Commande');
        $sheet->setCellValue('N1', 'Retour Commande');
        $sheet->setCellValue('O1', 'Commentaire');
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
        $sheet->getStyle('N1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('O1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
        $sheet->getStyle('N1')->getFont()->setBold(true);
        $sheet->getStyle('O1')->getFont()->setBold(true);
        $sheet->setTitle("Historique");
        $hitoriques = $stockRepository->findHistoriqueExcel();
        $i = 1;
        foreach($hitoriques as $hist){
            $i++;
            $sheet->setCellValue('A'.$i, $hist->getReference(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet->setCellValue('B'.$i, $hist->getDateCommande());
            $sheet->setCellValue('C'.$i, $hist->getClient());            
            $sheet->setCellValue('D'.$i, $hist->getArticle()->getDesignation());    
            $sheet->setCellValue('E'.$i, $hist->getQuantite());         
            $sheet->setCellValue('F'.$i, $hist->getDateSortiePrevue());            
            $sheet->setCellValue('G'.$i, $hist->getDateSortieEffectif());            
            $sheet->setCellValue('H'.$i, $hist->getDateRetourPrevu());            
            $sheet->setCellValue('I'.$i, $hist->getDateRetourEffectif());            
            $sheet->setCellValue('J'.$i, $hist->getNbJour());            
            $sheet->setCellValue('K'.$i, $hist->getUser());            
            $sheet->setCellValue('L'.$i, $hist->getMouvement());            
            $sheet->setCellValue('M'.$i, $hist->getUserSortie());            
            $sheet->setCellValue('N'.$i, $hist->getUserRetour());            
            $sheet->setCellValue('O'.$i, $hist->getCommentaire());            
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
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        // Create your Office 2007 Excel (XLSX Format)

        $sheet2 = $spreadsheet->createSheet();
        //$sheet->setActiveSheetIndex(1);
        $sheet2->setTitle("Payement");
        $sheet2->setCellValue('A1', 'Reference');
        $sheet2->setCellValue('B1', 'Date payement');
        $sheet2->setCellValue('C1', 'Montant');
        $sheet2->setCellValue('D1', 'Motif');
        $sheet2->setCellValue('E1', 'Type de Mouvement');
        $sheet2->setCellValue('F1', 'Moyen de Payement');
        $sheet2->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet2->getStyle('A1')->getFont()->setBold(true);
        $sheet2->getStyle('B1')->getFont()->setBold(true);
        $sheet2->getStyle('C1')->getFont()->setBold(true);
        $sheet2->getStyle('D1')->getFont()->setBold(true);
        $sheet2->getStyle('E1')->getFont()->setBold(true);
        $sheet2->getStyle('F1')->getFont()->setBold(true);
        $hitoriquepaye = $payeRepository->findHistoriqueExcel();
        $j = 1;
        foreach($hitoriquepaye as $hist){
            $j++;
            $sheet2->setCellValue('A'.$j, $hist->getRefstock(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $sheet2->setCellValue('B'.$j, $hist->getDatePayement());
            $sheet2->setCellValue('C'.$j, $hist->getMontant());            
            $sheet2->setCellValue('D'.$j, $hist->getMotifPayement());    
            $sheet2->setCellValue('E'.$j, $hist->getPayement());
            $sheet2->setCellValue('F'.$j, $hist->getTypePayement());            
            $sheet2->getStyle('A'.$j)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        }        
        $sheet2->getStyle('A')->getNumberFormat();
        $sheet2->getColumnDimension('A')->setAutoSize(true);
        $sheet2->getColumnDimension('B')->setAutoSize(true);
        $sheet2->getColumnDimension('C')->setAutoSize(true);
        $sheet2->getColumnDimension('D')->setAutoSize(true);
        $sheet2->getColumnDimension('E')->setAutoSize(true);
        $sheet2->getColumnDimension('F')->setAutoSize(true);

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

