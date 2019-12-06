<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Tricks;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use App\Repository\TricksRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{

    public function __construct(TricksRepository $TricksRepository, UserRepository $UserRepository){

        $this->TricksRepository = $TricksRepository;
        $this->UserRepository = $UserRepository;

    }

    /**
     * @Route("/tricks/{id}/comment/add", name="comments_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id): Response
    {

        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        $trick = $this->TricksRepository->findOneBy(['id' => $id]);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $comment->setTrick($trick);
            $comment->setUser($this->getUser());
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return new Response();

    }

    /**
     * @Route("/tricks/{id}-{slug}/comment/delete/{cid}", name="comments_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comments $comment, $id, $slug, $cid): Response
    {

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();

            return new Response('dd');

        }

        return new Response('fail');
    }
}
