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


class OwnerController extends Controller
{
     
    
    public function PersonListAction(Request $request, $page)
    {       
         $session = $this->getRequest()->getSession();       
            if ($session->has('login')) {
                $login = $session->get('login');
               
            }
        else {
              return $this->redirect($this->generateUrl('gate_admin_testloginpage'));           
             }
        
        
       $repository = $this->getDoctrine()->getRepository('GateAdminBundle:Owner');   
       //-------------------------------------------------------------- 
      
       $start = $page * 5 - 5;
         
         $em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
         $connection = $em->getConnection();
         $statement = $connection->prepare("SELECT * FROM owner where owner.showowner = 0 limit ?,?");
         $statement->bindValue(1,$start, "integer");
         $statement->bindValue(2,5, "integer");
         $statement->execute();
         $People = $statement->fetchAll();
  
    $currentPage = $page;     
    
    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository('GateAdminBundle:Owner')
    ->getAllPosts($currentPage);
   
    $limit = 5;
    $maxPages = ceil($posts->count() / $limit);
    $thisPage = $page;
       
       
       
       //--------------------------------------------------------------
    $Person = new \GateAdminBundle\Entity\Owner();
 
    $form = $this->createForm(\GateAdminBundle\Form\PersonType::class, $Person);
    $form1 = $this->createForm(\GateAdminBundle\Form\PersonDeleteType::class, $Person);
    $form2 = $this->createForm(\GateAdminBundle\Form\PersonEditType::class, $Person);  
    $form->handleRequest($request);
    $form1->handleRequest($request);
    $form2->handleRequest($request);
    
    $addpersonValid = true;       
    $editpersonValid = true;             
    $keyword = "0";
    
    
    
        $query1 = $this->getDoctrine()->getManager()    // ---- dinaminiai checkboxai prasideda
            
        ->createQuery('SELECT a FROM GateAdminBundle:Owner a WHERE a.showowner LIKE :title')
        ->setParameter('title', '%' . $keyword . '%')
        ->setMaxResults(5)
        ->setFirstResult($start);     
    
        $resultCollection = $query1->getResult();  
        $entries = array();      
        $Person2 = new \GateAdminBundle\Entity\Owner();
          
         
    $formBuilder = $this->createFormBuilder();

    foreach($resultCollection as $Person2){
        $formBuilder->add($Person2->getDID(),CheckboxType::class,array('label'=>' ','required'=>false));
    }
    
    $formBuilder->add('submit',SubmitType::class, array('label'=>'Ištrinti'));
  
    $Checkform = $formBuilder->getForm();

    $Checkform->handleRequest($request);
    
    
    if($Checkform->isSubmitted()){
        $data = $Checkform->getData();

        $em = $this->getDoctrine()->getEntityManager();

        foreach($resultCollection as $Person2){
            if($data[$Person2->getDID()]){
                $em->remove($Person2);
            }
        }

        $em->flush();
        
   return $this->redirect($this->generateUrl('gate_admin_PersonList', array("page" => $page)));  
    }      // ---- dinaminiai checkboxai baigiasi
               
               
        if ($form->isSubmitted() ) { // naujo asmens forma
        if ($form->isValid()){
        $Show = "0";   
        $Date = (new \DateTime());
        $Date->format('Y-m-d H:i:s');
        
        $Person = $form->getData();
        $Person->setShowowner($Show);
        $Person->setRegDate($Date);
        
     
        $em = $this->getDoctrine()->getManager();
        $em->persist($Person);
        $em->flush();
        return $this->redirect($this->generateUrl('gate_admin_PersonList', array("page" => $page)));
         }
                $addpersonValid = false;
               return $this->render('GateAdminBundle:Default:PersonList.html.twig', array('editpersonValid' =>  $editpersonValid ,'addpersonValid' =>  $addpersonValid, 'Admin' => $login, 'People' => $People,
                   'maxPages' => $maxPages, 'thisPage'=> $thisPage,  'newPersonForm' => $form->createView(), 'DeletePersonForm' => $form1->createView(),
                   'EditPersonForm' => $form2->createView(), 'CheckForm' => $Checkform->createView()));
         }
                     
                     
                     
                     
                     
        if ($form1->isSubmitted()) {    // ištrinimo forma    
        $id = $form1["did"]->getData();      
        $em1 = $this->getDoctrine()->getEntityManager();
        $Owner = $em1->getRepository('GateAdminBundle:Owner')->find($id);     
        $em1->remove($Owner);
        $em1->flush();             
                     
        
//         $em = $this->getDoctrine()->getManager();
//         $qb = $em->createQueryBuilder();
//         $query = $qb->update('GateAdminBundle:Owner', 'buss')
//         ->set('buss.showowner', ':value')
//         ->where('buss.did = :bussId')
//         ->setParameter('bussId',  $id)
//         ->setParameter('value', 1)
//        
//         ->getQuery();
//         $query->execute();
//         
//         
//         $em2 = $this->getDoctrine()->getManager();
//         $qb2 = $em2->createQueryBuilder();
//         $query2 = $qb2->update('GateAdminBundle:Vehicle', 'busss')
//         ->set('busss.showveh', ':value')
//         ->where('busss.did = :bussId')
//         ->setParameter('bussId',  $id)
//        ->setParameter('value', 1)
//        
//         ->getQuery();
//        $query2->execute();

        return $this->redirect($this->generateUrl('gate_admin_PersonList', array("page" => $page)));   
                 }
  
                 
         if ($form2->isSubmitted()) {    // redagavimo forma
         if ($form2->isValid()){
         $name = $form2["name"]->getData();
         $surname = $form2["surname"]->getData();
         $phonenumber = $form2["phonenumber"]->getData();
         $adress = $form2["adress"]->getData();
         $did = $form2["did"]->getData();    
             
         $em = $this->getDoctrine()->getManager();
         $qb = $em->createQueryBuilder();
         $query = $qb->update('GateAdminBundle:Owner', 'buss')
         ->set('buss.name', ':name')
         ->set('buss.surname', ':surname')
         ->set('buss.phonenumber', ':phonenumber')
         ->set('buss.adress', ':adress')
         ->where('buss.did = :bussId')
         ->setParameter('bussId',  $did)
         ->setParameter('name', $name)
         ->setParameter('surname', $surname)
         ->setParameter('phonenumber', $phonenumber)
         ->setParameter('adress', $adress)
         ->getQuery();

         $query->execute();
             
            
         return $this->redirect($this->generateUrl('gate_admin_PersonList', array("page" => $page)));
         }   
            $editpersonValid = false;
            return $this->render('GateAdminBundle:Default:PersonList.html.twig', array('editpersonValid' =>  $editpersonValid ,'addpersonValid' =>  $addpersonValid, 'Admin' => $login, 'People' => $People, 'maxPages' => $maxPages,
            'thisPage'=> $thisPage,  'newPersonForm' => $form->createView(), 'DeletePersonForm' => $form1->createView(),
            'EditPersonForm' => $form2->createView(), 'CheckForm' => $Checkform->createView()));
         }
                 
                 
        return $this->render('GateAdminBundle:Default:PersonList.html.twig', array('editpersonValid' =>  $editpersonValid , 'addpersonValid' =>  $addpersonValid, 'Admin' => $login, 'People' => $People, 'maxPages' => $maxPages, 'thisPage'=> $thisPage,  'newPersonForm' => $form->createView(), 'DeletePersonForm' => $form1->createView(), 'EditPersonForm' => $form2->createView(), 'CheckForm' => $Checkform->createView()));
    }
    
      public function personListAddCarAction(Request $request)
    {  
        
    }
   
    
 
 
    
     public function personprofileAction(Request $request, $id, $page)
    {
             
    
     #return $this->redirect($this->generateUrl('gate_admin_remind'));
               
      
                 $session = $this->getRequest()->getSession();       
            if ($session->has('login')) {
                $login = $session->get('login');
               
            }
        else {
              return $this->redirect($this->generateUrl('gate_admin_testloginpage'));           
             }
        
  
       $start = $page * 5 - 5;
$em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
$connection = $em->getConnection();

  $query1 = $this->getDoctrine()->getManager()    // ---- dinaminiai checkboxai prasideda
            
        ->createQuery('SELECT v FROM GateAdminBundle:Vehicle v WHERE v.did = :name')
      
        ->setParameter('name', $id)
        ->setMaxResults(5)
        ->setFirstResult($start);     
    
        $resultCollection = $query1->getResult();  
     
        $car2 = new \GateAdminBundle\Entity\Vehicle();
          
         
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
        
   return $this->redirect($this->generateUrl('gate_admin_personprofile', array("id" => $id ,"page" => $page = 1)));  
    }      // ---- dinaminiai checkboxai baigiasi
               
    //-------------------------------------------------------------- 
      
      
        $VehicleOwner = new \GateAdminBundle\Entity\Owner();
        $emPrime = $this->getDoctrine()->getEntityManager();
        $VehicleOwner = $emPrime->getRepository('GateAdminBundle:Owner')->find($id);     
       
        
    
    
    
    
    
        $fixedID = intval($id);  ;
     
        
        $statementPages = $connection->prepare("SELECT vehicle.vID, vehicle.dID, vehicle.licenseNum,"
                . " vehicle.brand, vehicle.model FROM vehicle WHERE vehicle.dID = ? limit ?,? ");
        
        $statementPages->bindValue(2,$start, "integer");
        $statementPages->bindValue(3,5, "integer");
        $statementPages->bindValue(1, $fixedID, "integer");
        $statementPages->execute();
        $CarPages = $statementPages->fetchAll();
  
    $currentPage = $page;     
    
    $emPages = $this->getDoctrine()->getManager();
    $posts = $emPages->getRepository('GateAdminBundle:Vehicle')
    ->getSpecificPosts($fixedID , $currentPage);
   
    $limit = 5;
    $maxPages = ceil($posts->count() / $limit);
    $thisPage = $page;
       
       
    $form = $this->createForm(\GateAdminBundle\Form\VehicleType::class);
    $form1 = $this->createForm(\GateAdminBundle\Form\VehicleDeleteType::class);
    $form2 = $this->createForm(\GateAdminBundle\Form\VehicleEditType::class);
    $Owner2 = new \GateAdminBundle\Entity\Owner();
    $VehOwnerForm = $this->createForm(\GateAdminBundle\Form\VehicleOwnerType::class, $Owner2);
    $Owner1 = new \GateAdminBundle\Entity\Owner();
    $VehOwnerForm1 = $this->createForm(\GateAdminBundle\Form\VehicleOwner1Type::class, $Owner1);
    $Owner = new \GateAdminBundle\Entity\Owner();  
    
    $form->handleRequest($request);
    $form1->handleRequest($request);
    $form2->handleRequest($request);
    
    
    
        $addVehValid = true;      
        $editVehValid = true;
    //--------------------------------------------------------------
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
         return $this->redirect($this->generateUrl('gate_admin_personprofile', array("id" => $id ,"page" => $page = 1)));
    }
     $addVehValid = false;  
     return $this->render('GateAdminBundle:Default:PersonProfile.html.twig', array(  'PrimeOwner' => $VehicleOwner,  'PersonId' =>$id, 'VehOwnerForm1' => $VehOwnerForm1->createView(), 'editVehValid' => $editVehValid,
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
                     
        return $this->redirect($this->generateUrl('gate_admin_personprofile', array("id" => $id ,"page" => $page = 1)));   
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
           return $this->redirect($this->generateUrl('gate_admin_personprofile', array("id" => $id ,"page" => $page = 1)));
        }
        
        
         $editVehValid = false;
          return $this->render('GateAdminBundle:Default:PersonProfile.html.twig', array( 'PrimeOwner' => $VehicleOwner, 'PersonId' =>$id,'VehOwnerForm1' => $VehOwnerForm1->createView(), 'editVehValid' => $editVehValid, 'VehOwnerForm' => $VehOwnerForm->createView(), 'addVehValid' => $addVehValid,  'Admin' => $login, 
         'Cars' => $CarPages, 'maxPages' => $maxPages, 'thisPage'=> $thisPage, 'newVehicleForm' => $form->createView(),
         'VehicleDeleteForm' => $form1->createView(), 'VehicleEditForm' => $form2->createView(), 'CheckForm' => $Checkform->createView()));
    
        
       
        }   
               
      
               
               
               
               return $this->render('GateAdminBundle:Default:PersonProfile.html.twig', array( 'PrimeOwner' => $VehicleOwner, 'PersonId' =>$id, 'VehOwnerForm1' => $VehOwnerForm1->createView(), 'editVehValid' => $editVehValid, 'VehOwnerForm' => $VehOwnerForm->createView(), 'addVehValid' => $addVehValid,  'Admin' => $login, 
         'Cars' => $CarPages, 'maxPages' => $maxPages, 'thisPage'=> $thisPage, 'newVehicleForm' => $form->createView(),
         'VehicleDeleteForm' => $form1->createView(), 'VehicleEditForm' => $form2->createView(), 'CheckForm' => $Checkform->createView()));
 
   
    }
    
    
   // public function personprofile1111Action()
   // {
         
     //   $request = $this->get('request');
    //    $id = $request->query->get('dID');
        
    // $em = $this->getDoctrine()->getEntityManager();
    // $repository = $em ->getRepository('GateAdminBundle:Person');
    
    // $Person = $repository->findOneBy(array('dID'=> $id));
      
     #return $this->redirect($this->generateUrl('gate_admin_remind'));
        
        
        
        
     //  return $this->render('GateAdminBundle:Default:PersonProfile.html.twig', array(
    //   'Person' => $Person
   // ));
   
   // }

   
    
}