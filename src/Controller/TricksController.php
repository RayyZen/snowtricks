<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Repository\TricksRepository;
use App\Form\TricksNewType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{

	/**
    * @var TricksRepository
    */
    private $repository;

    public function __construct(TricksRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
    * @Route("/", name="app_homepage")
    */
	public function index()
	{

		$tricks = $this->repository->findAllTricks();
        
        return $this->render('home.html.twig', [
        	'tricks' => $tricks,
        	'current_menu' => 'homepage'
        ]);

	}

	/**
    * @Route("/new-trick", name="tricks.new")
    */
    public function newTrick(Request $request): Response
    {
        
        $trick = new Tricks();
        $form = $this->createForm(TricksNewType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('message', 'Le post a bien été postée');

            return $this->redirectToRoute('app_homepage');

        } 

        return $this->render('tricks/new.html.twig', [
            'trickNewForm' => $form->createView(),
            'current_menu' => 'tricks'
        ]);

    }

}