<?php

namespace App\Controller;

//use App\Entity\Tricks;
//use App\Repository\TricksRepository;
//use App\Form\TricksNewFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{


    /**
    * @Route("/", name="app_homepage")
    */
	public function index()
	{
        
        return $this->render('home.html.twig');

	}

}