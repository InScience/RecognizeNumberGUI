<?php

namespace GateAdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GateAdminBundle\Form\AdministratorType;
use Symfony\Component\HttpFoundation\Session;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\DriverManager;


class VehicleController extends Controller
{
     public function VehicleListAction(Request $request, $page)
    {       
           $session = $this->getRequest()->getSession();       
            if ($session->has('login')) {
                $login = $session->get('login');
               
            }
        else {
              return $this->redirect($this->generateUrl('gate_admin_testloginpage'));           
             }
        
  
     
$em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
$connection = $em->getConnection();


    //-------------------------------------------------------------- 
      
       $start = $page * 5 - 5;
         
        $emPages = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
        $connectionPages = $emPages->getConnection();
      //  $statementPages = $connection->prepare("SELECT owner.dID, owner.name, owner.surname, vehicle.vID, vehicle.licenseNum, vehicle.brand, vehicle.model
       // FROM owner
       // INNER JOIN vehicle
       // ON owner.dID=vehicle.dID
       // ORDER BY vehicle.licenseNum limit ?,?");
        
           $statementPages = $connection->prepare("SELECT owner.dID, owner.name, owner.surname, vehicle.vID, vehicle.licenseNum, vehicle.brand, vehicle.model
        FROM owner
        INNER JOIN vehicle
        ON owner.dID=vehicle.dID
        WHERE vehicle.showveh = 0
        limit ?,?");
        
        $statementPages->bindValue(1,$start, "integer");
        $statementPages->bindValue(2,5, "integer");
        $statementPages->execute();
        $CarPages = $statementPages->fetchAll();
  
    $currentPage = $page;     
    
    $emPages = $this->getDoctrine()->getManager();
    $posts = $emPages->getRepository('GateAdminBundle:Vehicle')
    ->getAllPosts($currentPage);
   
    $limit = 5;
    $maxPages = ceil($posts->count() / $limit);
    $thisPage = $page;
       
       
       
    //--------------------------------------------------------------
 
 
    $form = $this->createForm(\GateAdminBundle\Form\VehicleType::class);
    $form1 = $this->createForm(\GateAdminBundle\Form\VehicleDeleteType::class);
    $form2 = $this->createForm(\GateAdminBundle\Form\VehicleEditType::class);
    
    //$Owner = new \GateAdminBundle\Entity\Owner();  
    $form->handleRequest($request);
    $form1->handleRequest($request);
    $form2->handleRequest($request);
    
    $Owner = new \GateAdminBundle\Entity\Owner();
    $VehOwnerForm = $this->createForm(\GateAdminBundle\Form\VehicleOwnerType::class, $Owner);
    $Owner1 = new \GateAdminBundle\Entity\Owner();
    $VehOwnerForm1 = $this->createForm(\GateAdminBundle\Form\VehicleOwner1Type::class, $Owner1);
   
         $keyword = "0";  
         $query1 = $this->getDoctrine()->getManager()    // ---- dinaminiai checkboxai prasideda
       
        ->createQuery('SELECT a FROM GateAdminBundle:Vehicle a WHERE a.showveh LIKE :title')
        ->setParameter('title', '%' . $keyword . '%')
        ->setMaxResults(5)
        ->setFirstResult($start);     
    
        $resultCollection = $query1->getResult();  
     
        $car2 = new \GateAdminBundle\Entity\Vehicle();
          
        
//        ->createQuery('SELECT a FROM GateAdminBundle:Owner a WHERE a.showowner LIKE :title')
//        ->setParameter('title', '%' . $keyword . '%')
//        ->setMaxResults(5)
//        ->setFirstResult($start);     
//        
        
         
    $formBuilder = $this->createFormBuilder();

    foreach($resultCollection as $car2){
        $formBuilder->add($car2->getVID(),CheckboxType::class,array('label'=>' ','required'=>false));
    }
    
    $formBuilder->add('submit',SubmitType::class, array('label'=>'Ištrinti'));
  
    $Checkform = $formBuilder->getForm();

    $Checkform->handleRequest($request);
    
    
    if($Checkform->isSubmitted()){
        $data = $Checkform->getData();

        $em = $this->getDoctrine()->getEntityManager();

        foreach($resultCollection as $car2){
            if($data[$car2->getVID()]){
                $em->remove($car2);
            }
        }

        $em->flush();
        
   return $this->redirect($this->generateUrl('gate_admin_VehicleList', array("page" => $page)));  
    }      // ---- dinaminiai checkboxai baigiasi
               
                 $addVehValid = true;      
                 $editVehValid = true;
    
    
    if ($form->isSubmitted() ) {
    if  ($form->isValid()){
        
          $Licensenum = $form["licensenum"]->getData();
          $brandname = $form["brand"]->getData();
          $modelname = $form["model"]->getData();
          $Ownerdid = $form["did"]->getData();
          
        $VehOwner = new \GateAdminBundle\Entity\Owner();
        $em1 = $this->getDoctrine()->getEntityManager();
        $VehOwner = $em1->getRepository('GateAdminBundle:Owner')->find($Ownerdid);    
          
          
          $NewVehicle = new \GateAdminBundle\Entity\Vehicle();
          $NewVehicle->setDID($VehOwner);
          $NewVehicle->setLicenseNum($Licensenum);
          $NewVehicle->setBrand($brandname);
          $NewVehicle->setModel($modelname);
          $NewVehicle->setShowveh("0"); 
          
          
         $em = $this->getDoctrine()->getManager();
         $em->persist($NewVehicle);
         $em->flush();
         return $this->redirect($this->generateUrl('gate_admin_VehicleList', array("page" => $page)));   
    }
     $addVehValid = false;  
     return $this->render('GateAdminBundle:Default:VehicleList.html.twig', array('VehOwnerForm1' => $VehOwnerForm1->createView(), 'editVehValid' => $editVehValid,
         'VehOwnerForm' => $VehOwnerForm->createView(), 'addVehValid' => $addVehValid,  'Admin' => $login, 
         'Cars' => $CarPages, 'maxPages' => $maxPages, 'thisPage'=> $thisPage, 'newVehicleForm' => $form->createView(),
         'VehicleDeleteForm' => $form1->createView(), 'VehicleEditForm' => $form2->createView(), 'CheckForm' => $Checkform->createView()));
    
    }       
     if ($form1->isSubmitted() && $form1->isValid()) {    // ištrinimo forma  
         
         
         
        $vid = $form1["vid"]->getData();    
        $em1 = $this->getDoctrine()->getEntityManager();
        $Veh = $em1->getRepository('GateAdminBundle:Vehicle')->find($vid);     
        $em1->remove($Veh);
        $em1->flush();             
            
        
//         $em2 = $this->getDoctrine()->getManager();
//         $qb2 = $em2->createQueryBuilder();
//         $query2 = $qb2->update('GateAdminBundle:Vehicle', 'busss')
//         ->set('busss.showveh', ':value')
//         ->where('busss.vid = :bussId')
//         ->setParameter('bussId',  $vid)
//        ->setParameter('value', 1)
//        
//         ->getQuery();
//        $query2->execute();

        
        
        return $this->redirect($this->generateUrl('gate_admin_VehicleList', array("page" => $page)));   
                 }
    
    
      if ($form2->isSubmitted() ) {    // redagavimo forma
        if ($form2->isValid()){
       
         $Licensenum = $form2["licensenum"]->getData();
         $brandname = $form2["brand"]->getData();
         $modelname = $form2["model"]->getData();
         $vid = $form2["vid"]->getData();    
             
        $Ownerdid = $form2["did"]->getData();
          
        $VehOwner = new \GateAdminBundle\Entity\Owner();
        $em1 = $this->getDoctrine()->getEntityManager();
        $VehOwner = $em1->getRepository('GateAdminBundle:Owner')->find($Ownerdid);    
         
         
         $em = $this->getDoctrine()->getManager();
         $qb = $em->createQueryBuilder();
         $query = $qb->update('GateAdminBundle:Vehicle', 'buss')
         ->set('buss.did', ':did')
         ->set('buss.licensenum', ':licensenum')
         ->set('buss.brand', ':brand')
         ->set('buss.model', ':model')
         ->where('buss.vid = :bussvid')
         ->setParameter('bussvid',  $vid)
         ->setParameter('did',  $VehOwner)
         ->setParameter('licensenum', $Licensenum)
         ->setParameter('brand', $brandname)
         ->setParameter('model', $modelname)
    
         ->getQuery();

         $query->execute();
          return $this->redirect($this->generateUrl('gate_admin_VehicleList', array("page" => $page)));   
        }
        
        
         $editVehValid = false;
          return $this->render('GateAdminBundle:Default:VehicleList.html.twig', array('VehOwnerForm1' => $VehOwnerForm1->createView(), 'editVehValid' => $editVehValid, 'VehOwnerForm' => $VehOwnerForm->createView(), 'addVehValid' => $addVehValid,  'Admin' => $login, 
         'Cars' => $CarPages, 'maxPages' => $maxPages, 'thisPage'=> $thisPage, 'newVehicleForm' => $form->createView(),
         'VehicleDeleteForm' => $form1->createView(), 'VehicleEditForm' => $form2->createView(), 'CheckForm' => $Checkform->createView()));
    
        
       
        }       
     
    
        return $this->render('GateAdminBundle:Default:VehicleList.html.twig', array('VehOwnerForm1' => $VehOwnerForm1->createView(), 'editVehValid' => $editVehValid, 'VehOwnerForm' => $VehOwnerForm->createView(),
            'addVehValid' => $addVehValid,
            'Admin' => $login, 'Cars' => $CarPages, 'maxPages' => $maxPages,
            'thisPage'=> $thisPage, 'newVehicleForm' => $form->createView(),
            'VehicleDeleteForm' => $form1->createView(), 'VehicleEditForm' => $form2->createView(),
            'CheckForm' => $Checkform->createView()));
    }
    

    
}