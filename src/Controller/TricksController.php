<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\TricksImages;
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
    private $TricksRepository;

    public function __construct(TricksRepository $TricksRepository)
    {
        $this->TricksRepository = $TricksRepository;
    }

    /**
    * @Route("/", name="app_homepage")
    */
	public function index()
	{

		$tricks = $this->TricksRepository->findAllTricks();
        
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
        $image = new TricksImages();

        $formTrick = $this->createForm(TricksNewType::class, $trick);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted() && $formTrick->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($trick);
            $entityManager->flush();

            $tricks_directory = $this->getParameter('tricks_directory');

            $thumbnailFile = $formTrick['tricksImages']['thumbnail']->getData();

            if (isset($thumbnailFile)) {

                try {

                    $filename = uniqid() .'.' .$thumbnailFile->guessExtension();
                    $thumbnailFile->move($tricks_directory, $filename);

                } catch (FileException $e) {

                }

                $image->setTrick($trick);
                $image->setFilename($filename);
                $image->setIsThumbnail(1);
                $entityManager->persist($image);
                $entityManager->flush();

            }

            if (isset($aditionalFile)) {

                foreach ($aditionalFile as $file) {

                    try {

                        $filename = uniqid() .'.' .$thumbnailFile->guessExtension();
                        $thumbnailFile->move($tricks_directory, $filename);
                        
                    } catch (Exception $e) {
                        
                    }

                    $image->setTrick($trick);
                    $image->setFilename($filename);
                    $image->setIsThumbnail(0);
                    $entityManager->persist($image);
                    $entityManager->flush();

                }

            }            

            $this->addFlash('succes', 'Your trick has been posted');

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('tricks/new.html.twig', [
            'trickNewForm' => $formTrick->createView(),
            'current_menu' => 'tricks'
        ]);

    }

    

}