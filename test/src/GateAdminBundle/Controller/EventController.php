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


class EventController extends Controller
{
    public function indexAction(Request $request, $page)
    {       
           $session = $this->getRequest()->getSession();       
            if ($session->has('login')) {
                $login = $session->get('login');
               
            }
        else {
              return $this->redirect($this->generateUrl('gate_admin_testloginpage'));           
             }
        
          $repository = $this->getDoctrine()->getRepository('GateAdminBundle:Event');   
       //-------------------------------------------------------------- 
      
          
         $start = $page * 10 - 10;
         
//         $em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
//         $connection = $em->getConnection();
//         $statement = $connection->prepare("SELECT * FROM event limit ?,?");
//         $statement->bindValue(1,$start, "integer");
//         $statement->bindValue(2,10, "integer");
//         $statement->execute();
//         $People = $statement->fetchAll();
  
    $currentPage = $page;     
    
    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository('GateAdminBundle:Event')
    ->getAllPosts($currentPage);
   
    $limit = 10;
    $maxPages = ceil($posts->count() / $limit);
    $thisPage = $page;
       
       
       
          
          
          
      
         $em = $this->getDoctrine()->getManager(); // ...or getEntityManager() prior to Symfony 2.1
         $connection = $em->getConnection();
         $statement = $connection->prepare("SELECT event.confidence, event.recNumber, raspfoto.date, vehicle.brand, vehicle.model, owner.name, owner.surname FROM event "
                 . "LEFT JOIN raspfoto ON event.rpID=raspfoto.rpID "
                 . "LEFT JOIN vehicle ON event.vID=vehicle.vID "
                 . "LEFT JOIN owner ON vehicle.dID=owner.dID "
                 . "LEFT JOIN states ON event.sID=states.sID ORDER BY raspfoto.date DESC limit ?,? ");
         $statement->bindValue(1,$start, "integer");
         $statement->bindValue(2,10, "integer");
         $statement->execute();
         $Events = $statement->fetchAll();
  
        
        return $this->render('GateAdminBundle:Default:index.html.twig', array('Admin' => $login, 'Events' => $Events, 'maxPages' => $maxPages, 'thisPage'=> $thisPage));
    }
    
  
    
}