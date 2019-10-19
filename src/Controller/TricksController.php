<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\TricksImages;
use App\Repository\TricksRepository;
use App\Form\TricksNewType;
use Doctrine\Common\Persistence\ObjectManager;
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

    public function __construct(TricksRepository $TricksRepository, ObjectManager $entityManager)
    {
        $this->TricksRepository = $TricksRepository;
        $this->entityManager = $entityManager;
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
        $image1 = new TricksImages();
        

        $formTrick = $this->createForm(TricksNewType::class, $trick);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($trick);
            $entityManager->flush();

            $tricks_directory = $this->getParameter('tricks_directory');

            $thumbnailFile = $formTrick['tricksImages']['thumbnail']->getData();
            $additionalFile = $formTrick['tricksImages']['additional']->getData();

            if (isset($thumbnailFile)) {

                try {

                    $filename = uniqid() .'.' .$thumbnailFile->guessExtension();
                    $thumbnailFile->move($tricks_directory, $filename);

                } catch (FileException $e) {

                }

                $image1->setTrick($trick);
                $image1->setFilename($filename);
                $image1->setIsThumbnail(1);
                $entityManager->persist($image1);
                $entityManager->flush();

            }

            if (isset($additionalFile)) {

                foreach ($additionalFile as $file) {

                    $image2 = new TricksImages();

                    try {

                        $filename = uniqid() .'.' .$file->guessExtension();
                        $file->move($tricks_directory, $filename);
                        
                    } catch (Exception $e) {
                        
                    }

                    $image2->setTrick($trick);
                    $image2->setFilename($filename);
                    $image2->setIsThumbnail(0);
                    $entityManager->persist($image2);

                }

                $entityManager->flush();

            }            

            $this->addFlash('success', 'Your trick has been posted');

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('tricks/new.html.twig', [
            'trickNewForm' => $formTrick->createView(),
            'current_menu' => 'tricks'
        ]);

    }

    /**
     * @Route("/tricks/detail/{id}", name="tricks.delete", methods="DELETE")
     * @param Tricks $trick
     */
    public function trickDelete(Tricks $trick, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' .$trick->getId(), $request->get('_token'))) {
            $this->entityManager->remove($trick);
            $this->entityManager->flush();
            $this->addFlash('message', 'The trick has been removed');
            return $this->redirectToRoute('app_homepage');
        }
    }

}