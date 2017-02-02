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


class DefaultController extends Controller
{
     public function AdminListAction(Request $request, $page)
    { 
          $session = $this->getRequest()->getSession();       
            if ($session->has('login')) {
                $login = $session->get('login');
               
            }
        else {
              return $this->redirect($this->generateUrl('gate_admin_testloginpage'));           
             }
             
             
         $repository = $this->getDoctrine()->getRepository('GateAdminBundle:Administrator');
                 
         $start = $page * 5 - 5;
         
         $em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
         $connection = $em->getConnection();
         $statement = $connection->prepare("SELECT * FROM administrator limit ?,?");
         $statement->bindValue(1,$start, "integer");
         $statement->bindValue(2,5, "integer");
         $statement->execute();
         $People = $statement->fetchAll();
            
         
    $currentPage = $page;     
    
    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository('GateAdminBundle:Administrator')
    ->getAllPosts($currentPage);
    

    // You can also call the count methods (check PHPDoc for `paginate()`)
    # Total fetched (ie: `5` posts)
  //  $totalPostsReturned = $posts->getIterator()->count();

    # Count of ALL posts (ie: `20` posts)
  //  $totalPosts = $posts->count();

    # ArrayIterator
  //  $iterator = $posts->getIterator();

    // render the view (below)
         
    $limit = 5;
    $maxPages = ceil($posts->count() / $limit);
    $thisPage = $page;
    
   
       $query = $this->getDoctrine()->getManager()
            
        ->createQuery('SELECT a FROM GateAdminBundle:Administrator a')
        ->setMaxResults(5)
        ->setFirstResult($start);
       
    
   
        $resultCollection = $query->getResult();
    
        $entries = array();
        
  
        
        $Person2 = new \GateAdminBundle\Entity\Administrator();
        
         foreach($resultCollection as $Person2){
           var_dump($Person2->getName());
             
        }
      
    $Person = new \GateAdminBundle\Entity\Administrator();
        
    $formBuilder = $this->createFormBuilder();

    foreach($resultCollection as $Person){
        $formBuilder->add($Person->getAID(),CheckboxType::class,array('label'=>' ','required'=>false));
    }
    
    $formBuilder->add('submit',SubmitType::class);
  
    $Checkform = $formBuilder->getForm();

    $Checkform->handleRequest($request);
    
    
    if($Checkform->isValid()){
        $data = $Checkform->getData();

        $em = $this->getDoctrine()->getEntityManager();

        foreach($resultCollection as $Person){
            if($data[$Person->getAID()]){
                $em->remove($Person);
            }
        }

        $em->flush();
        
  return $this->redirect($this->generateUrl('gate_admin_AdminList', array("page" => $page)));   
    }
    
      $Owner = new \GateAdminBundle\Entity\Owner();
      $VehOwnerForm = $this->createForm(\GateAdminBundle\Form\VehicleOwnerType::class, $Owner);
    
    return $this->render('GateAdminBundle:Default:AdminList.html.twig',   array( 'VehOwnerForm' => $VehOwnerForm->createView(),
        'CheckForm' => $Checkform->createView(),
        'Admin' => $login, 'People' => $People, 'maxPages' => $maxPages, 'thisPage'=> $thisPage));
    }
    
    
  
    
      public function personListAddCarAction(Request $request)
    {  
        
    }
  
    
   
    
}