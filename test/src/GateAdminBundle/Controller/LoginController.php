<?php

namespace GateAdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GateAdminBundle\Form\AdministratorType;
use Symfony\Component\HttpFoundation\Session;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;



class LoginController extends Controller
{
  
    public function loginAction(Request $request)
    {
        $session = $this->getRequest()->getSession();

        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em ->getRepository('GateAdminBundle:Administrator');
        
    $Admin = new \GateAdminBundle\Entity\Administrator();
 
    $form = $this->createForm(\GateAdminBundle\Form\AdministratorType::class, $Admin);

    $form->handleRequest($request);
    
    $form1 = $this->createForm(\GateAdminBundle\Form\RemindType::class, $Admin);

    $form1->handleRequest($request);
    $page = 1;
    
    
    if ($form->isSubmitted() && $form->isValid()) {
 
        $Admin = $form->getData();
         
        $username = $Admin->getName();
        $password = $Admin->getPassword();
        $validUser = true;
        
        
         $user = $repository->findOneBy(array('name'=>$username, 'password' => $password));
         if($user){
             $login = new \GateAdminBundle\Entity\Administrator();
             $login->setName($username);
             $login->setPassword($password);
             $session->set('login', $login);
            // return $this->render('GateAdminBundle:Default:index.html.twig', array('Admin' => $Admin));  
             return $this->redirect($this->generateUrl('gate_admin_homepage', array("page" => $page)));
         }
         else{
             return $this->render('GateAdminBundle:Login:login.html.twig', array(
        'ourform' => $form->createView(),
        'remindform' => $form1->createView()  ,    
         'validUser' => $validUser            
    ));
         }
    } 
     if ($form1->isSubmitted()){
     if ($form1->isValid()) {
        $remindValid = true;
        $Admin = $form->getData();
         
        $name = $Admin->getName();
   
     
        $email = $repository->findOneBy(array('email' => $name));
         if($email){
             
        
        
        $namer = $email->getName();
        $pass = $email->getPassword();
        $message = \Swift_Message::newInstance()
        ->setSubject('Reminder')
        ->setFrom('gatewatchermail@gmail.com')
        ->setTo($name)
        ->setBody(
            $this->renderView(
                'Emails/registration.html.twig',
                array('name' => $namer, 'password' => $pass)
            ),
            'text/html'
        ); 
         $this->get('mailer')->send($message);
        
        return $this->render('GateAdminBundle:Login:login.html.twig', array(
        'ourform' => $form->createView(),
        'remindform' => $form1->createView()  ,  
        'remindValid' => $remindValid     
    ));
             
        
         }
        else {
             $remindValid = false;
        return $this->render('GateAdminBundle:Login:login.html.twig', array(
        'ourform' => $form->createView(),
        'remindform' => $form1->createView()   , 
        'remindValid' => $remindValid      
    ));
            
        }
        
        
        
        
        
         }    
     }
    else //if $request->getMethod()!='POST'
        {
            if ($session->has('login')) {
                $login = $session->get('login');
                $username = $login->getName();
                $password = $login->getPassword();

                $user = $repository->findOneBy(array('name'=>$username, 'password' => $password));
                return $this->redirect($this->generateUrl('gate_admin_homepage', array("page" => $page)));


            }

             #  return $this->render('DWMUserBundle:Default:signin.html.twig');

        }
    
    
    
     return $this->render('GateAdminBundle:Login:login.html.twig', array(
        'ourform' => $form->createView(),
        'remindform' => $form1->createView()      
    ));
    
    

}

public function logoutAction(Request $request)
    {
      
        $session=$this->getRequest()->getSession();
        $session->clear();
        return $this->redirect($this->generateUrl('gate_admin_testloginpage'));
   
    }


}