<?php

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\{
    Result,
    Gene,
    ResultReport,
    ResultSection,
    ResultSubsection,
    ReportGeneratorSecond,
    ResultMarker
    };


class ReportService
{   
    private $em;
    private $kernel_interface;
    private $projectDir;
    private $result_reports;
    public $reportGeneratorSecond  = null;

    public function __construct(EntityManagerInterface $em, KernelInterface $kernel_interface ){

        $dotenv = new Dotenv();
        $dotenv->load($kernel_interface ->getProjectDir().'/.env');

        $this->projectDir = $kernel_interface->getProjectDir();

        if (!getenv('UPLOADS_FILES')) {
            $this->projectDir.= "/public/uploads/files/process/";
        }else{
            $this->projectDir.= getenv('UPLOADS_FILES');
        }

        $this->kernel_interface = $kernel_interface;
        $this->em = $em;
    }

    // public function getReportClients($clients_array,$report_generator,$report_generator_second){
    //     return 1;
    // }

    public function processFile($report_process){
        $reportGeneratorSecond = null;

        $file_path = $this->projectDir.$report_process->getPath(); 
        
        $archivo = fopen($file_path, "r");

        $list_errors = [];
        $error = false;


        if(!feof($archivo)) {
            $personas = explode("\t", fgets($archivo));
            if (sizeof($personas)<4){
                $list_errors[]=['error'=>'head_file_empty'];
                $error = true;
            }
        }

        $clients_array = [];
        $clients = $report_process ->getClients();
        if(empty($clients)){
            $list_errors[]=['error'=>'client_empty'];
            $error = true;
        }else{
            $clients_array = explode(',',$clients); 
        }
        // get the markers of the subsections in sections of the report
        $report_logos = $report_process->getReportLogos();
        $report_logos_array = [];
        foreach ($report_logos as $key => $report_logo) {
           $report_logos_array[]=$report_logo;
        }

        $markers_subsection = [];
        $report = $report_process->getReport();
        $markers_rep_array=[];
        foreach ($report->getSectionReports() as $sections_rep) {
            foreach ($sections_rep->getSection()->getSubsections() as $key => $subsection_rep) {
                $markers_rep_string = $subsection_rep->getMarkers();
                if($markers_rep_string){
                    $markers_rep_array_aux = explode(',',$markers_rep_string);
                    foreach ($markers_rep_array_aux as $marker_aux) {
                        $markers_rep_array[] = [
                            'marker'=>$marker_aux ,
                            'subsection'=>$subsection_rep ,
                            'section'=>$sections_rep];
            
                    }
                }
            }
        }

       


        //make the match between the excel and the markers of the subsections
        $line_result = 0;
        $markers_rep_array_temp = [];
        foreach ($markers_rep_array as $index_marker => $markers_rep) {
            
            $descriptions_excel = $this->em->createQueryBuilder()
                ->select('r')
                ->from(Result::class, 'r')
                ->where('r.marker= :marker')
                ->andWhere('r.type = :subsection')
                ->setParameter('marker',$markers_rep['marker'])
                ->setParameter('subsection', $markers_rep['subsection']->getTitle())
                ->getQuery()->getResult();
                
         
            $line = []; 
            if(!empty($descriptions_excel)){
            //get the list of all genotypes     
                foreach ($descriptions_excel as $index_result => $description) {
                    
                    $answer_list = [];
                    foreach ($markers_rep['subsection']->getAnswers() as $answer) {
                        $answer_list[] = [$answer->getAnswer(),  $answer->getDescriptiveAnswer()];
                    } 
                    $line = [
                        
                        'gene' => $description->getGene(),
                        'genotype' =>$description->getGenotype(),
                        'answers'=>  (
                                    $markers_rep['subsection']->getIsAutomatic()) ? 
                                    [$description->getResult() , $description->getDescriptiveResult()]: 
                                    $answer_list,
                        'bibliography'=>  ($markers_rep['subsection']->getBibliography()) ? $markers_rep['subsection']->getBibliography(): $description->getBiography(),
                        'note' => $description->getNote()
                    ];

                    
                    $markers_rep_array_temp[$line_result] = [
                            'marker'=> $markers_rep['marker'] ,
                            'subsection'=>$markers_rep['subsection'] ,
                            'section'=>$markers_rep['section'],
                            'line' => $line 
                        ] ;
                    $line_result += 1;
                }
                    
            }else {
                $list_errors[]=['error'=>'marker_not_found_import','marker'=>$markers_rep['marker'],'title'=>$markers_rep['subsection']->getTitle()];
                $error = true;
            }
        }

        $markers_rep_array = $markers_rep_array_temp;
        
        $aux_clients_reports = [];
        for ($cli_pos=0; $cli_pos < (sizeof($clients_array)); $cli_pos++) { 
            $aux_clients_reports[$cli_pos] = new ResultReport;
            $aux_clients_reports[$cli_pos]->setClient($clients_array[$cli_pos]);
            if(!empty($report_logos_array)){
                if(array_key_exists($cli_pos,$report_logos_array)){
                    $aux_clients_reports[$cli_pos]->setReportLogo($report_logos_array[$cli_pos]);
                }
            }
        }

        // dump($aux_clients_reports);
        // die;
       $resg="";
       $fila = 0;
        if(empty($list_errors)){
            while(!feof($archivo)) 
                {
                    $resg = fgets($archivo);

                    if (trim($resg) != "\r\n"){
                        $fila++;
                        //split de lines by space

                        $lineas = explode("\t", $resg);

                        if((count($lineas)-3) != sizeof($clients_array)){
                            
                            if($lineas != '' && $lineas[0] != '' && !empty($lineas)){
                                $list_errors[]=['error'=>'number_clients_size','line'=>$fila + 1];
                                $error = true;
                                break;
                            }
                            
                        }

                        for ($j = 0; $j <= (count($markers_rep_array) - 1); $j++) {
                            //the markers is the first element
                            if ($markers_rep_array[$j]['marker'] == $lineas[0]){                
                                //como comienza a partir de item 4 los marcadores o
                                for ($i = 3; $i <= ((count($lineas)-1)); $i++) {    

                                    //get the report result of the client
                                    $result_report = $aux_clients_reports[$i - 3];
                                    
                                    //for remove lines

                                    $lineas[$i] = str_replace("\r\n","", $lineas[$i]);
                                    $lineas[$i] = str_replace("\n","", $lineas[$i]);
                                    $lineas[$i] = str_replace("\r","", $lineas[$i]);

                                    if ($markers_rep_array[$j]['line']['genotype'] == $lineas[$i]){
                                        
                                    
                                        $result_section = null;    
                                        $section = $markers_rep_array[$j]['section']->getSection();
                                        foreach ($result_report->getResultSections() as  $result_section_aux) {
                                            if($result_section_aux->getSection() == $section){
                                                $result_section = $result_section_aux;
                                            }
                                        }
                                        if(!$result_section){
                                            $result_section = new ResultSection();
                                            $result_section->setSection($section);
                                            $result_section->setOrderNumber($markers_rep_array[$j]['section']->getOrderNumber());
                                            $result_section->setNote($markers_rep_array[$j]['line']['note']);
                                            $result_report->addResultSection($result_section);
                                        }

                                      
                                        $result_sub_section = null;
                                        $sub_section = $markers_rep_array[$j]['subsection'];
                                        foreach ($result_section->getResultSubsections() as  $result_sub_section_aux) {
                                            if($result_sub_section_aux->getSubSection() == $sub_section){
                                                $result_sub_section = $result_sub_section_aux;
                                            }
                                        }


                                        if(!$result_sub_section){
                                            $result_sub_section = new ResultSubSection();
                                            $result_sub_section->setSubSection($sub_section);
                                        

                                            $result_sub_section->setMarkersFound($markers_rep_array[$j]['marker']);
                                            if(!$sub_section->getIsAutomatic()){
                                                $result_sub_section->setAnswers($markers_rep_array[$j]['line']['answers']);
                                            }
                                            $result_section->addResultSubSection($result_sub_section);
                                        }

                                        $result_marker = new ResultMarker();
                                        $result_marker->setMarker($markers_rep_array[$j]['marker']);
                                        $result_marker->setAnswers($markers_rep_array[$j]['line']['answers']);
                                        $result_marker->setBibliography($markers_rep_array[$j]['line']['bibliography']);
                                        $result_marker->setGene($markers_rep_array[$j]['line']['gene']);
                                        $result_marker->setGenotype($markers_rep_array[$j]['line']['genotype']);
                                        $result_sub_section->addResultMarker($result_marker);
                                        
                                    } 
                                }
                            }
                        }
                    }
                }



                $report_generator_second = new ReportGeneratorSecond();
                $report_generator_second ->setReport($report_process->getReport());
                $report_generator_second ->setReportGenerator($report_process);

                foreach ($aux_clients_reports as $result_report) {
                    $report_generator_second->addClientReport($result_report);
                }

                $this->em->persist($report_generator_second);
                $this->em->flush(); 
        }
        
        
        fclose($archivo);

 
        if(!$error){
            return ['state'=> true, 'result'=>$report_generator_second];
        }else{
            return ['state'=> false,'errors'=>$list_errors];
        }
    
    }

    public function makeResultReport($markers_rep_array_item,$gene){
        
        
    }
}