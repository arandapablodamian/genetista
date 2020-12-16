<?php

namespace App\Controller;

use App\Controller\AdminController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Service\ReportService;
use App\Service\ValidationService;
use Symfony\Component\HttpFoundation\Request;

use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

// generar pdf
use Dompdf\{
    Dompdf,
    Options
};

use App\Entity\{
    Result,
    Answer,
    Gene,
    Report,
    ReportGenerator,
    ReportGeneratorSecond,
    ResetPasswordRequest,
    ResultReport,
    ResultSection,
    ResultSubsection,
    Section,
    SectionReport,
    Subsection,
    User
};

class ReportProcessController extends AdminController
{

    private $clients_examples = "Jose Lucas, Maria Tevez, Roxana Ariel";
    private $markers = "Marcador1, marcador2";
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'report_service' => ReportService::class,
            'validation_service' => ValidationService::class,
            'translations' => TranslatorInterface::class,
        ]);
    }

    
    public function persistReportGeneratorEntity($entity){
        $validation = $this->step1ReportValidation($entity);
        if($validation['validation'])
        {
            $this->em->persist($entity);
            $this->em->flush();
        }else{
            $this->addFlash("danger",'Some errors ocurred in the processing of the reports.Please try again.');  
        }
        $this->step2Report($entity);
    }

    public function step1ReportValidation($entity){
        //make the validations of the step1 persist
        $validation = true;
        $errors= [];
        return ['validation'=>$validation,'errors'=>$errors];
    }

    public function step2Report($report_generator){   
        $process = $this->get('report_service')->processFile($report_generator);
        $trans = $this->get('translations');
        if($process['state']){
            $report_generator_second = $process['result'];
            $reports_result = $report_generator_second->getClientReports();
            if(!empty($reports_result)){
                $session = new Session();
                $session->set('report_pos',0);
                $first_report = $reports_result[0];
                $this->request->query->set('referer', 'editResultReport/'.$first_report->getId()); 
            }else{
                $this->addFlash("danger",'Some errors ocurred in the processing of the reports in the step 2.Please try again.');
                $query = array(
                    'entity' => 'ReportGenerator',
                    'action' => 'new'
                );
                $this->request->query->set('referer', '?'.http_build_query($query)); 
            }
        }else{
            $errors = $process['errors'];
            foreach ($errors as $error) {
                if($error['error']=='marker_not_found_import'){
                    $this->addFlash('danger',$trans->trans($error['error']).'. '.$trans->trans('marker').': '.$error['marker'].'. '.$trans->trans('subsection_title').':' .$trans->trans($error['title']) );
                }elseif($error['error']=='number_clients_size'){
                    $this->addFlash('danger',$trans->trans($error['error']).'. '.$trans->trans('line').': '.$error['line']);
                }else{
                    $this->addFlash('warning',$error['error']);
                }
            }

            $this->addFlash("danger",'Some errors ocurred in the processing of the reports in the step 2.Please try again.');
            $query = array(
                'entity' => 'ReportGenerator',
                'action' => 'new'
            );
            $this->request->query->set('referer', '?'.http_build_query($query)); 
        }
        
    }

    /**
     * @Route("/currentClientView", name="currentClientView")
     */
    public function current_client_view($current_result_client){

        $query = array(
            'entity' => 'ResultReport',
            'action' => 'edit',
            'id'=>$current_result_client->getId()
        );
        

        $this->request->query->set('referer', '?'.http_build_query($query)); 
    }


    /**
     * @Route("/editResultReport/{id}", name="editResultReport")
     */
    public function editResultReport($id){

        $result_report = $this->getDoctrine()->getRepository(ResultReport::class)->find($id);

        $session = new Session();
        $report_pos = $session->get('report_pos');
        $actual = $id;
        return $this->render('resultReport/form.html.twig', [
            'result_report' => $result_report,
        ]);
    }

    
    /**
     * @Route("/change_report_result", name="change_report_result")
     */
    public function change_report_result(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $result_subsection = false;
        $process_report_id = $request->request->get('process_report_id');
        $reportGeneratorSecond = $this->getDoctrine()->getRepository(ReportGeneratorSecond::class)->find($process_report_id);
        if($request->request->all()){
            $valores_enviados = $request->request->all();
            foreach ($valores_enviados as $key => $value) {
                $array_aux = explode('aditional_text_',$key);
                if(!empty($array_aux[1])){
                    $id_subsection = $array_aux[1];
                    $result_subsection = $this->getDoctrine()->getRepository(ResultSubSection::class)->find($id_subsection);
                    $result_subsection->setAditionalText($value);
                    $entityManager->flush($result_subsection);
                }

                $array_aux = explode('answer_',$key);
                if(!empty($array_aux[1])){
                    $answer_descriptive = explode('|',$value);
                    $id_subsection = $array_aux[1];
                    $result_subsection = $this->getDoctrine()->getRepository(ResultSubSection::class)->find($id_subsection);
                    $result_subsection->setAnswers([$answer_descriptive]);
                    $entityManager->flush($result_subsection);
                }
            }
            
        }
    
        $reports = $reportGeneratorSecond->getClientReports();
        $reports_array = [];
        foreach ($reports as $key => $report_elem) {
            $reports_array[$key]=$report_elem;
        }
 
        $session = new Session();
        $report_pos = $session->get('report_pos');
        $report_pos = $report_pos + 1;
        $session->set('report_pos',$report_pos);

      
        if(array_key_exists($report_pos , $reports_array)){
            $result_report = $reports[$report_pos];
            return $this->redirectToRoute(
                'editResultReport',
                ['id'=>$result_report->getId()
            ]);
        }else{
            return $this->redirectToRoute(
                'print_reports',
                ['id'=>$process_report_id
            ]);
        }
     
        
    }


     /**
     * @Route("/print_reports/{id}", name="print_reports")
     */
    public function print_reports($id){
        $process = $this->getDoctrine()->getRepository(ReportGeneratorSecond::class)->find($id);
        return $this->render('resultReport/download_pdfs_reports.html.twig', [
            'process' => $process
        ]); 
    }

    
     /**
     * @Route("/download_report/{id}", name="download_report")
     */
    public function download_report($id,Pdf $pdf){

        $result_report = $this->getDoctrine()->getRepository(ResultReport::class)->find($id);

        $body = $this->renderView('pdf/reportArt2.html.twig',['result_report'=>$result_report]);
        $header = $this->renderView('pdf/header.html.twig',['result_report'=>$result_report]);
        $footer = $this->renderView('pdf/footer.html.twig',['result_report'=>$result_report]);

        $filename = "report.pdf";
        return new PdfResponse(
            $pdf->getOutputFromHtml($body,[
                'images'=>true,
                'enable-javascript' =>true,
                'page-size' =>'A4',
                'print-media-type' => true,
                'image-dpi' => '300',
                'load-error-handling' => 'ignore',
                'load-media-error-handling' => 'ignore',
                'margin-left'   => 1,
                'margin-right'   => 1,
                'header-html' => $header,
                'footer-html' => $footer,
            ]),
            $filename
        );
        // $entityManager = $this->getDoctrine()->getManager();

        // $product = 
        // // $this->getDoctrine()
        // ->getRepository(Product::class)
        // ->findBy(['title'=>'titulo']);

        // $pdfOptions = new Options();
        // $pdfOptions->set('defaultFont', 'Arial');
        // $pdfOptions->set('isRemoteEnabled', TRUE);
        // $pdfOptions->set('debugKeepTemp', TRUE);
        // $pdfOptions->set('isHtml5ParserEnabled', true);
        // $pdfOptions->set('enable_remote', true);

        // // Instantiate Dompdf with our options
        // $dompdf = new Dompdf($pdfOptions);
        
        // // Retrieve the HTML generated in our twig file

        // // return $html;die;
        // // Load HTML to Dompdf
        // $dompdf->loadHtml($html);

        // // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        // $dompdf->setPaper('A4', 'portrait');

        // // Render the HTML as PDF
        // $dompdf->render();

        // // Output the generated PDF to Browser (force download)
        // $dompdf->stream("reportArt2.pdf", [
        //     "Attachment" => true
        // ]);
        // die;
        //magic for pdf generate
    }

}