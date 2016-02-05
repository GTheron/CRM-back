<?php

namespace App\CrmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AppCrmBundle:Default:index.html.twig', array('name' => $name));
    }
}
