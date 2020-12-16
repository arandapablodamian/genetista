<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;

//importations for form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File as HttpFoundationFile;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\Report;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
{
    private $passwordEncoder;

    // public $kernel;
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'passwordEncoder' => UserPasswordEncoderInterface::class,
        ]);
    }

    
    


    // public function __construct(KernelInterface $kernel )
    // {
    //     $this->kernel = $kernel;
    // }

    public function persistUserEntity($user)
    {
        if(!empty($user->getPlainPassword())){
            $user->setPassword($this->get('passwordEncoder')->encodePassword(
                $user,
                $user->getPlainPassword()
            ));
        }
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {   
        if(!empty($user->getPlainPassword())){
            $user->setPassword($this->get('passwordEncoder')->encodePassword(
                $user,
                $user->getPlainPassword()
            ));
        }
        
        parent::updateEntity($user);

    }

    // public function persistUserEntity($user)
    // {
    //     $this->get('fos_user.user_manager')->updateUser($user, false);
    //     parent::persistEntity($user);
    // }

    // public function updateUserEntity($user)
    // {
    //     $this->get('fos_user.user_manager')->updateUser($user, false);
    //     parent::updateEntity($user);
    // }

    /**
     * @Route(path="/result_report", name="result_report")
     */
    public function resultReport($id_result_report)
    {   
        $result_report = $this->getDoctrine()
        ->getRepository(ResultReport::class)
        ->find($id_result_report);


        return $this->render('report_generator/step2.html.twig', [
            'result_report' => $result_report,
        ]);
       
    }

    /**
     * @Route(path="/ruta_paso3", name="ruta_paso3")
     */
    public function ruta_paso3()
    {   

        return $this->render('report_generator/step3.html.twig', []);
       
    }


    /**
     * @Route(path="/result_report_save", name="result_report_save")
     */
    public function resultReportSave(Request $request)
    {   
        // guardo los elementos de las secciones y subsecciones resulta que cree


        $next_result_report = $this->getNextReportResultClient($reportGeneratorSecond,$report_result);
        if($next_result_report){
            return $this->render('report_generator/step2.html.twig', [
                'result_report' => $next_result_report,
            ]);
        }else{
            return $this->render('report_generator/list_pdf_reports.html.twig', [
                'reports_process' => $report_result->getReportGeneratorSecond(),
            ]);
        }
        
    }

    public function getNextReportResultClient($reportGeneratorSecond,$report_result){
        return $report_result;
    }


}
