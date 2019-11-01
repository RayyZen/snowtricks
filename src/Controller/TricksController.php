<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\TricksImages;
use App\Repository\TricksRepository;
use App\Repository\TricksImagesRepository;
use App\Form\TricksNewType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TricksController extends AbstractController
{

	/**
    * @var TricksRepository
    */
    private $TricksRepository;

    /**
    * @var TricksImagesRepository
    */
    private $TricksImagesRepository;

    public function __construct(TricksRepository $TricksRepository, TricksImagesRepository $TricksImagesRepository, ObjectManager $entityManager)
    {
        $this->TricksRepository = $TricksRepository;
        $this->TricksImagesRepository = $TricksImagesRepository;
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
     * @Route("tricks/details/{id}-{slug}", name="tricks.details", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function detailsTrick($slug, $id)
    {

        $trick = $this->TricksRepository->find($id);
        $thumbnail = $this->TricksImagesRepository->findTrickThumbnail($trick->getId());
        $images = $this->TricksImagesRepository->findAllTrickImages($trick->getId());

        //dd($thumbnail);

        return $this->render('tricks/details.html.twig', [
            'trick' => $trick,
            'thumbnail' => $thumbnail,
            'images' => $images
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

            } else {

                $image1->setTrick($trick);
                $image1->setFilename('default.png');
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

            $this->addFlash('trick-success','Your trick has been added to our list.');

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('tricks/new.html.twig', [
            'trickNewForm' => $formTrick->createView(),
            'current_menu' => 'tricks'
        ]);

    }

    /**
     * @Route("/tricks/details/{id}", name="tricks.delete", methods="DELETE")
     * @param Tricks $trick
     */
    public function deleteTrick(Tricks $trick, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' .$trick->getId(), $request->get('_token'))) {

            $images = $this->TricksImagesRepository->findAllTrickImages($trick->getId());
            $tricks_directory = $this->getParameter('tricks_directory');

            foreach ($images as $image) {
               
                $filesystem = new Filesystem();
                $filename = $image->getFilename();

                if ($filename != 'default.png') {
                     $filesystem->remove($tricks_directory .'/' .$filename);
                }

            }

            $this->entityManager->remove($trick);
            $this->entityManager->flush();

            $this->addFlash('trick-delete', 'Your trick has been removed');
            return $this->redirectToRoute('app_homepage');
        }
    }

}